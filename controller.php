public function print()
{
    return view ('print.print');
}
public function detail_p( $id_kelas)
{

    // Get all jadwal and sort by custom order
    // $jj = jadwal::all()->sortBy(function($item) use ($customOrder) {
    //     return array_search($item->hari, $customOrder);
    // });

    //return view('jadwal.index', compact('jadwal'));

    // memanggil view tambah
    $hari = DB::table('guru')
    ->join('jadwal', 'guru.id_guru', '=', 'jadwal.id_guru')
    ->join('pelajaran', 'pelajaran.id_pelajaran', '=', 'jadwal.id_pelajaran')
    ->join('waktu', 'waktu.id_waktu', '=', 'jadwal.id_waktu')
    ->get();
    $jadwal = DB::table('guru')
    ->join('jadwal', 'guru.id_guru', '=', 'jadwal.id_guru')
    ->join('pelajaran', 'pelajaran.id_pelajaran', '=', 'jadwal.id_pelajaran')
    ->join('waktu', 'waktu.id_waktu', '=', 'jadwal.id_waktu')
    ->join('hari', 'hari.id_hari', '=', 'jadwal.id_hari')
    ->where('id_kelas',$id_kelas)
    // ->orderBy(function($hari) use ($customOrder) {
    //     return array_search($hari->hari, $customOrder);
    // })
    ->orderBy('waktu.id_waktu', 'ASC')
    ->orderBy('jam', 'ASC')
    //->groupBy('ruangan.keterangan_ruangan')
    ->get();
    
    $jadwall = DB::table('guru') // Gunakan fasad DB daripada Guru::join
    ->join('jadwal', 'guru.id_guru', '=', 'jadwal.id_guru')
    ->join('pelajaran', 'pelajaran.id_pelajaran', '=', 'jadwal.id_pelajaran')
    ->join('hari', 'hari.id_hari', '=', 'jadwal.id_hari')
    ->where('jadwal.id_kelas', $id_kelas)
    ->groupBy('guru.id_guru', 'guru.nama_guru')
    ->selectRaw('*, 
        MAX(CASE WHEN hari.nama_hari = "Senin" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Senin,
        MAX(CASE WHEN hari.nama_hari = "Selasa" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Selasa,
        MAX(CASE WHEN hari.nama_hari = "Rabu" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Rabu,
        MAX(CASE WHEN hari.nama_hari = "Kamis" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Kamis,
        MAX(CASE WHEN hari.nama_hari = "Jumat" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Jumat,
        MAX(CASE WHEN hari.nama_hari = "Sabtu" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Sabtu,
        MAX(CASE WHEN hari.nama_hari = "Minggu" THEN pelajaran.nama_pelajaran ELSE NULL END) AS Minggu')
    ->get();
    // passing data ruangan yang didapat ke view edit_ruangan.blade.php
    return view('print.detail' , ['jadwal' => $jadwal],['jadwall'=>$jadwall]);

}