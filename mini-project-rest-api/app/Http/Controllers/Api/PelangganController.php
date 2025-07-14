<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Log;
use DB;

class PelangganController extends Controller
{
    public function index()
    {
        return Pelanggan::orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'nama_pelanggan' => 'required|string|max:255',
                'domisili' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
            ]);

            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $data['nama_pelanggan'],
                'domisili' => $data['domisili'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'alamat' => $data['alamat'],
            ]);

            // Generate kode_pelanggan
            $pelanggan->kode_pelanggan = 'PELANGGAN' . $pelanggan->id;
            $pelanggan->save();
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
        return Pelanggan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'nama_pelanggan' => 'required|string|max:255',
                'domisili' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string|max:255',
                'alamat' => 'required|string|max:255',
            ]);

            $pelanggan = Pelanggan::findOrFail($id);
            $pelanggan->update($request->all());
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
            $data = Pelanggan::findOrFail($id);
    
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
