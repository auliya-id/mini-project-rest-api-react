<?php
namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Log;
use DB;

class BarangController extends Controller
{
    public function index()
    {
        return Barang::orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'warna' => 'required|string|max:255',
            ]);

            $barang = Barang::create([
                'nama_barang' => $data['nama_barang'],
                'kategori' => $data['kategori'],
                'harga' => $data['harga'],
                'warna' => $data['warna'],
            ]);

            // Generate kode_barang
            $barang->kode_barang = 'BRG' . $barang->id;
            $barang->save();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil tambah data!',
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
            Log::error("ERROR APP : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ups Terjadi Kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        return Barang::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'kategori' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'warna' => 'required|string|max:255',
            ]);

            $barang = Barang::findOrFail($id);
            $barang->update($data);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update data!',
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
            Log::error("ERROR APP : " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ups Terjadi Kesalahan update: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Barang::findOrFail($id);
    
            $data->delete();
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