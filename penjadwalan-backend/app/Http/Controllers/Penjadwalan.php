<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Genetik;
use App\Models\PenjadwalanModel;
use Illuminate\Support\Facades\Validator;

class Penjadwalan extends Controller
{
	public function penjadwalan(Request $request)
	{
		$obj_penjadwalan = new PenjadwalanModel();

		// $checkSKS = $obj_penjadwalan->GetSks(1);
		// echo $checkSKS=>sks;
		// echo $checkSKS[0]['sks'];
		// print_r($checkSKS);
		// echo $checkSKS[0]->sks;
		// exit;
		$validator = Validator::make($request->all(), [
			'semester'      	=> 'required',
			'tahun_akademik'    => 'required'
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors(), 400);
		};

		$i_semester		  	= $request->semester;
		$i_tahun_akademik   = $request->tahun_akademik;

		// $obj_penjadwalan = new PenjadwalanModel();
		$data_kelas = $obj_penjadwalan->GetKelas($i_semester, $i_tahun_akademik);
		$data_jam = $obj_penjadwalan->GetJam();
		$data_hari = $obj_penjadwalan->GetHari();
		$data_ruang_teori = $obj_penjadwalan->GetRuang('TEORI');
		$data_ruang_praktikum = $obj_penjadwalan->GetRuang('LABORATORIUM');
		$data_time_off_dosen = $obj_penjadwalan->GetTimeOffDosen();

		if (count($data_kelas) == 0) {
			return response()->json([
				'status'  => false,
				'message' => 'Tidak Ada Data Semester Atau Tahun Akademik Yang Sesuai'
			], 404);
		} else {
			$jenis_semester = '';
			$tahun_akademik = '';
			$jumlah_populasi = 10;
			$crossOver = 0.70;
			$mutasi = 0.40;
			$jumlah_generasi = 10000;

			$genetik = new Genetik(
				$jenis_semester,
				$tahun_akademik,
				$jumlah_populasi,
				$crossOver,
				$mutasi,
				//~~~BUG!~~
				/*                               
							1 senin 5
							2 selasa 4
							3 rabu 3
							4 kamis 2
							5 jumat 1                                 
                             */
				5, //kode hari jumat                                
				'4-5-6', //kode jam jumat
				//jam dhuhur tidak dipake untuk sementara
				6
			); //kode jam dhuhur
			$genetik->AmbilData($data_kelas, $data_jam, $data_hari, $data_ruang_teori, $data_ruang_praktikum, $data_time_off_dosen);
			$genetik->Inisialisai();

			date_default_timezone_set("Asia/Jakarta");
			$time_start = microtime(true);
			$date_start = date('m/d/Y h:i:s a', time());

			$total_waktu_fitness = 0;
			$total_waktu_seleksi = 0;
			$total_waktu_crossover = 0;
			$total_waktu_mutasi = 0;

			$found = false;
			$fitnessAfterMutation = array();

			for ($i = 0; $i < $jumlah_generasi; $i++) {
				if (empty($fitnessAfterMutation)) {
					$t_start = microtime(true);

					$fitness = $genetik->HitungFitness();

					$t_end = microtime(true);
					$total_waktu_fitness += $t_end - $t_start;
				} else {
					$fitness = $fitnessAfterMutation;
				}

				$t_start = microtime(true);

				$genetik->Seleksi($fitness);
				//$child_index = $genetik->StartCrossOver();

				$t_end = microtime(true);
				//echo '<br>seleksi:'.$t_end.'-'.$t_start;
				$total_waktu_seleksi += $t_end - $t_start;

				$t_start = microtime(true);

				$genetik->StartCrossOver();

				$t_end = microtime(true);
				$total_waktu_crossover += $t_end - $t_start;

				$t_start = microtime(true);

				//$fitnessAfterMutation = $genetik->Mutasi($fitness, $child_index);
				$fitnessAfterMutation = $genetik->Mutasi($fitness);

				$t_end = microtime(true);
				$total_waktu_mutasi += $t_end - $t_start;

				/*echo '<pre>';
				echo '<br>fitness after mutation:';
				print_r($fitnessAfterMutation);
				echo '</pre>';*/

				for ($j = 0; $j < count($fitnessAfterMutation); $j++) {
					//test here
					if ($fitnessAfterMutation[$j] == 1) {

						//$this->db->query("TRUNCATE TABLE jadwalkuliah");

						$jadwal_kuliah = array(array());
						$jadwal_kuliah = $genetik->GetIndividu($j);

						$dataAddOn = [];
						$no = 0;
						foreach ($jadwal_kuliah as $key => $value) {
							$checkSKS = $obj_penjadwalan->GetSks($value[0]);
							if ($checkSKS[0]->sks == 2) {
								$dataAddOn[$no] = [
									0 => $value[0],
									1 => $value[1] + ($checkSKS[0]->sks - 1),
									2 => $value[2],
									3 => $value[3],
								];
								$no++;
							} else if ($checkSKS[0]->sks == 3) {
								for ($k = 2; $k >= 1; $k--) {
									$dataAddOn[$no] = [
										0 => $value[0],
										1 => $value[1] + ($checkSKS[0]->sks - $k),
										2 => $value[2],
										3 => $value[3],
									];
									$no++;
								}
							};
						}
						// print_r($jadwal_kuliah);
						// echo '----------------------------------------------------------------------------------------------------------------------------';
						// print_r($dataAddOn);
						// exit;
						// print_r($checkSKS = $obj_penjadwalan->GetSks($value));
						// echo 'baris jadwal :' . count($jadwal_kuliah);
						// echo 'baris jadwal tambahan :' . count($dataAddOn);
						// print_r($jadwal_kuliah);
						// echo '-------------------------------------------------------------------------------------------------------------------------------------------------';
						// print_r($dataAddOn);
						$jadwal_akhir = array_merge($jadwal_kuliah, $dataAddOn);

						// exit;
						$obj_penjadwalan->KosongkanJadwal();
						for ($k = 0; $k < count($jadwal_akhir); $k++) {
							$obj_penjadwalan->InsertJadwal($jadwal_akhir[$k][0], $jadwal_akhir[$k][1], $jadwal_akhir[$k][2], $jadwal_akhir[$k][3]);
						}

						/*               for($k = 0; $k < count($jadwal_kuliah);$k++){
						
						$kode_pengampu = intval($jadwal_kuliah[$k][0]);
						$kode_jam = intval($jadwal_kuliah[$k][1]);
						$kode_hari = intval($jadwal_kuliah[$k][2]);
						$kode_ruang = intval($jadwal_kuliah[$k][3]);
						$this->db->query("INSERT INTO jadwalkuliah(kode_pengampu,kode_jam,kode_hari,kode_ruang) ".
										"VALUES($kode_pengampu,$kode_jam,$kode_hari,$kode_ruang)");
						
						
						}*/

						//var_dump($jadwal_kuliah);
						//exit();

						$found = true;
					}

					if ($found) {
						break;
					}
				}
				//echo '<br>xxx';var_dump($x);
				//echo 'generasi:'.$i.' ';
				//var_dump($found);
				/*         echo '<br>total waktu fitness pertama saja:'.$total_waktu_fitness;
				echo '<br>total waktu seleksi:'.$total_waktu_seleksi;
				echo '<br>total waktu crossover:'.$total_waktu_crossover;
				echo '<br>total waktu mutasi & fitness:'.$total_waktu_mutasi;
				echo '<br>total waktu fitness:'.$genetik->total_waktu_fitness;*/

				// --- tambahan
				//$fitness = $genetik->HitungFitness();
				//$genetik->Seleksi($fitness);
				// --- end tambahan

				if ($found) {
					break;
				}
			}

			if (!$found) {
				return response()->json([
					'status'  => false,
					'message' => 'Tidak ditemukan solusi optimal'
				], 404);
			}
		}

		$time_end = microtime(true);
		$date_end = date('m/d/Y h:i:s a', time());
		$durasi = $time_end - $time_start;
		//response json
		return response()->json([
			'status'  => true,
			'message' => 'Jadwal berhasil dibuat',
			'generasi' => $i,
			'durasi proses' => intdiv($durasi, 60) . ':' . ($durasi % 60)
		], 200);
	}
}
