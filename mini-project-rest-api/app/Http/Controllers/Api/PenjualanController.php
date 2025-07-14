<?php
namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\PenjualanItem;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Barang;
use Log;
use DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['pelanggan', 'items.barang'])->orderByDesc('id')->get();

        $result = $penjualan->map(function ($p) {
            return [
                'id' => $p->id,
                'id_pelanggan' => $p->pelanggan->id ?? '',
                'kode_nota' => $p->kode_nota,
                'tanggal' => $p->tanggal,
                'subtotal' => $p->subtotal,
                'kode_pelanggan' => $p->pelanggan->kode_pelanggan ?? '',
                'nama_pelanggan' => $p->pelanggan->nama_pelanggan ?? '',
                'alamat' => $p->pelanggan->alamat ?? '',
                'items' => $p->items->map(function ($i) use ($p) {
                    return [
                        'id' => $i->id ?? '',
                        'id_penjualan' => $p->id ?? '',
                        'id_barang' => $i->barang->id ?? '',
                        'qty' => $i->qty,
                        'kode_barang' => $i->barang->kode_barang ?? '',
                        'nama_barang' => $i->barang->nama_barang ?? '',
                        'warna' => $i->barang->warna ?? '',
                        'harga' => $i->barang->harga ?? '',
                    ];
                }),
            ];
        });

        return response()->json($result);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'id_pelanggan' => 'required',
                'tanggal' => 'required|date',
                'items' => 'required|array',
                'items.*.id_barang' => 'required',
                'items.*.qty' => 'required|integer|min:1',
            ]);

            // Hitung subtotal
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $barang = Barang::where('id', $item['id_barang'])->firstOrFail();
                $subtotal += $barang->harga * $item['qty'];
            }

            // Simpan penjualan
            $penjualan = Penjualan::create([
                'id_pelanggan' => $data['id_pelanggan'],
                'tanggal' => $data['tanggal'],
                'subtotal' => $subtotal
            ]);

            // Generate kode_nota
            $penjualan->kode_nota = 'NOTA' . $penjualan->id;
            $penjualan->save();

            // Simpan item penjualan
            foreach ($data['items'] as $item) {
                $barang = Barang::where('id', $item['id_barang'])->firstOrFail();
                PenjualanItem::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $barang->id,
                    'qty' => $item['qty']
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan!',
            ]);

        } catch (ValidationException $e) {
            DB::rollBack();

            $allMessages = collect($e->errors())->flatten()->implode(', ');
            return response()->json([
                'success' => false,
                'message' => $allMessages,
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("ERROR APP: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['items.barang', 'pelanggan'])->findOrFail($id);

        return response()->json([
            'id' => $penjualan->id,
            'id_pelanggan' => $penjualan->id_pelanggan,
            'kode_nota' => $penjualan->kode_nota,
            'tanggal' => $penjualan->tanggal,
            'subtotal' => $penjualan->subtotal,
            'kode_pelanggan' => $penjualan->pelanggan->kode_pelanggan,
            'nama_pelanggan' => $penjualan->pelanggan->nama_pelanggan,
            'alamat' => $penjualan->pelanggan->alamat,
            'items' => $penjualan->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'id_penjualan' => $item->id_penjualan,
                    'id_barang' => $item->barang->id,
                    'qty' => $item->qty,
                    'kode_barang' => $item->barang->kode_barang,
                    'nama_barang' => $item->barang->nama_barang,
                    'warna' => $item->barang->warna,
                ];
            })
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'id_pelanggan' => 'required',
                'tanggal' => 'required|date',
                'subtotal' => 'required|numeric',
                'items' => 'required|array',
                'items.*.id_barang' => 'required',
                'items.*.qty' => 'required|integer|min:1',
            ]);

            // Hitung subtotal
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $barang = Barang::where('id', $item['id_barang'])->firstOrFail();
                $subtotal += $barang->harga * $item['qty'];
            }

            $penjualan = Penjualan::findOrFail($id);
            $penjualan->update([
                'id_pelanggan' => $data['id_pelanggan'],
                'tanggal' => $data['tanggal'],
                'subtotal' => $subtotal,
            ]);

            // Hapus item lama
            PenjualanItem::where('id_penjualan', $penjualan->id)->delete();

            // Tambah item baru
            foreach ($data['items'] as $item) {
                PenjualanItem::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $item['id_barang'],
                    'qty' => $item['qty'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui.',
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();

            $allMessages = collect($e->errors())->flatten()->implode(', ');
            return response()->json([
                'success' => false,
                'message' => $allMessages,
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("ERROR APP: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan update: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            PenjualanItem::where('id_penjualan', $id)->delete();
            Penjualan::destroy($id);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil hapus data!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("ERROR APP : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ups Terjadi Kesalahan: ' . $e->getMessage(),
            ]);
        }
    }
}
