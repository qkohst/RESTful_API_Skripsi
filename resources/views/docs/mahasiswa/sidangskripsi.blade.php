<article class="docs-article" id="section-26">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Sidang Skripsi</h1>
    <p>
      Setelah proses bimbingan skripsi selesai, mahasiswa dapat mengajukan Sidang Skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-26-1">
    <h3 class="section-heading">Pengajuan Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/sidangskripsi</small>
    </h4>
    <p>
      Pengajuan sidang skripsi dengan mengunggah file skripsi, untuk kemudian menunggu persetujuan dosen pembimbing.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Request Body -->
    <h5 class="pt-2">Request body:</h5>
    <div class="callout-block callout-block-success">
      <div class="pt-0">
        <h5>file_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> file (.pdf)
          </small>
        </h5>
      </div>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "File uploaded successfully",
    "data": {
      "id": 5,
      "judul_skripsi": {
        "id": 12,
        "nama_judul_skripsi": "Indonesia Raya"
      },
      "file_sidang_skripsi": {
        "nama_file": "sidang-1412160002.pdf",
        "url": "fileSidang/sidang-1412160002.pdf"
      },
      "status_sidang_skripsi": "Pengajuan",
      "created_at": "1 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->


  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-26-2">
    <h3 class="section-heading">Status Persetujuan Dosen Pembimbing</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/sidangskripsi/persetujuandosbing</small>
    </h4>
    <p>
      Melihat status persetujuan sidang skripsi oleh dosen pembimbing, yang mana jika terdapat salah satu status persetujuan yang ditolak, mahasiswa harus melakukan pengajuan sidang skripsi ulang.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Submission status",
    "data": {
      "id": 6,
      "judul_skripsi": {
        "id": 12,
        "nama_judul_skripsi": "Indonesia Raya"
      },
      "persetujuan_pembimbing1_sidang_skripsi": "Antrian",
      "catatan_pembimbing1_sidang_skripsi": null,
      "persetujuan_pembimbing2_sidang_skripsi": "Antrian",
      "catatan_pembimbing2_sidang_skripsi": null,
      "tanggal_pengajuan_sidang_skripsi": "2021-07-02 23:46:27"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-26-3">
    <h3 class="section-heading">Waktu Sidang</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/sidangskripsi/waktu</small>
    </h4>
    <p>
      Melihat data waktu dan tempat sidang skripsi yang telah ditentukan oleh admin prodi.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Information Waktu Sidang",
    "data": {
      "id": 7,
      "dosen_penguji1_sidang_skripsi": {
        "id": 23,
        "nama_dosen": "Andik Adi Suryanto, S.Kom.,M.Kom",
        "nidn_dosen": "0724068909"
      },
      "dosen_penguji2_sidang_skripsi": {
        "id": 24,
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
        "nidn_dosen": "0714048502"
      },
      "waktu_sidang_skripsi": "2021-07-02 12:00:00",
      "tempat_sidang_skripsi": "Lab Riset"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-26-4">
    <h3 class="section-heading">Hasil Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilsidangskripsi</small>
    </h4>
    <p>
      Melihat data hasil verifikasi pelaksanaan Sidang Skripsi oleh dosen pembimbing dan dosen penguji.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "List of Data Hasil Sidang Skripsi",
    "data": [
      {
        "id": 1,
        "dosen": {
          "id": 10,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "status_dosen": "Pembimbing 1"
        },
        "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
        "catatan_hasil_sidang_skripsi": "Ut proident nostrud voluptate veniam occaecat laborum."
      },
      {
        "id": 2,
        "dosen": {
          "id": 14,
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905",
          "status_dosen": "Pembimbing 2"
        },
        "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
        "catatan_hasil_sidang_skripsi": "Laboris aliqua duis in dolor laborum anim occaecat consequat exercitation do in voluptate ipsum amet."
      },
      {
        "id": 3,
        "dosen": {
          "id": 12,
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402",
          "status_dosen": "Penguji 1"
        },
        "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
        "catatan_hasil_sidang_skripsi": "Laboris sit ullamco aliquip cillum nostrud proident."
      },
      {
        "id": 4,
        "dosen": {
          "id": 13,
          "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
          "nidn_dosen": "0714048502",
          "status_dosen": "Penguji 2"
        },
        "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
        "catatan_hasil_sidang_skripsi": "Qui ea nostrud commodo aliquip proident ea eiusmod esse est."
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-26-5">
    <h3 class="section-heading">Hasil Sidang Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilsidangskripsi/{id}</small>
    </h4>
    <p>
      Melihat data hasil Sidang Skripsi berdasarkan ID. Data ini dapat digunakan untuk melihat detail revisi hasil pelaksanaan Sidang Skripsi.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Details Data Sidang Skripsi",
    "data": {
      "id": 1,
      "dosen": {
        "id": 10,
        "nama_dosen": "Andy Haryoko, ST.,M.T.",
        "nidn_dosen": "0726047704",
        "status_dosen": "Pembimbing 1"
      },
      "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
      "catatan_hasil_sidang_skripsi": "Ut proident nostrud voluptate veniam occaecat laborum."
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-26-6">
    <h3 class="section-heading">Rekap Nilai Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilseminarproposal/daftarnilai</small>
    </h4>
    <p>
      Melihat data rekap nilai hasil pelaksaan Sidang Skripsi.
    </p>

    <!-- Parameter -->
    <h5>Request parameters:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">Authorization
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <label for="token"><i>Default value </i>: Bearer {api_token}</label>
                <input name="token" type="text" class="form-control bg-light text-black" placeholder="Bearer {api_token}">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">Accept
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>
              <fieldset disabled>
                <input type="text" class="form-control bg-light text-black" placeholder="aplication/json">
              </fieldset>
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_key
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(query)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "List of Data Nilai Sidang Skripsi",
    "data": {
      "id": 3,
      "mahasiswa": {
        "id": 2,
        "nama_mahasiswa": "Kukoh Santoso",
        "npm_mahasiswa": "1412170001"
      },
      "program_studi": {
        "id": 1,
        "fakultas_program_studi": "Fakultas Teknik",
        "nama_program_studi": "Teknik Informatika"
      },
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "waktu_sidang_skripsi": "2021-05-29 09:00:00",
      "tempat_sidang_skripsi": "Lab Data Mining",
      "dosen_pembimbing_1": {
        "id": 10,
        "nama_dosen": "Andy Haryoko, ST.,M.T.",
        "nidn_dosen": "0726047704"
      },
      "dosen_pembimbing_2": {
        "id": 14,
        "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
        "nidn_dosen": "0724068905"
      },
      "dosen_penguji_1": {
        "id": 12,
        "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
        "nidn_dosen": "0716058402"
      },
      "dosen_penguji_2": {
        "id": 13,
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
        "nidn_dosen": "0714048502"
      },
      "rekap_nilai_sidang": {
        "rata2_nilai_a_hasil_sidang_skripsi": 92,
        "rata2_nilai_b_hasil_sidang_skripsi": 88,
        "rata2_nilai_c_hasil_sidang_skripsi": 90,
        "jumlah_rata2_nilai_hasil_sidang_skripsi": 270,
        "nilai_akhir_hasil_sidang_skripsi": 90
      },
      "rekap_nilai_seminar": {
        "rata2_nilai_a_hasil_seminar_proposal": 84,
        "rata2_nilai_b_hasil_seminar_proposal": 84,
        "rata2_nilai_c_hasil_seminar_proposal": 85,
        "jumlah_rata2_nilai_hasil_seminar_proposal": 252,
        "nilai_akhir_hasil_seminar_proposal": 84
      },
      "nilai_akhir": 88
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

    <!-- Keterangan Nilai -->
    <h5 class="mt-0">Keterangan Nilai:</h5>
    <div class="alert alert-info" role="alert">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>Nilai A</th>
            <td>
              Nilai Proses Bimbingan Proposal / Skripsi
            </td>
          </tr>
          <tr>
            <th>Nilai B</th>
            <td>
              Nilai Naskah Proposal / Skripsi
            </td>
          </tr>
          <tr>
            <th>Nilai C</th>
            <td>
              Nilai Pelaksanaan Seminar Proposal / Sidang Skripsi
            </td>
          </tr>
          <tr>
            <th>Nilai Akhir</th>
            <td>
              Nilai Akhir dari (40%*nilai_akhir_seminar)+(60%*nilai_akhir_sidang)
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </section>
  <!--//section-->
</article>