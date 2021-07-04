<article class="docs-article" id="section-19">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Sidang Skripsi</h1>
    <p>
      Proses pengelolaan data Sidang Skripsi oleh admin prodi. Mulai dari proses penentuan waktu sidang, verifikasi hasil sidang skripsi, dan laporan nilai hasil sidang skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-3" id="item-19-1">
    <h3 class="section-heading">Lihat Data Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/sidangskripsi</small>
    </h4>
    <p>
      Melihat semua data Sidang Skripsi Mahasiswa sesuai program studi admin prodi
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
    "message": "List of Data Sidang Skripsi",
    "data": [
      {
        "id": 4,
        "mahasiswa": {
          "id": 3,
          "npm_mahasiswa": "1412170002",
          "nama_mahasiswa": "Maimunah"
        },
        "judul_skripsi": {
          "id": 7,
          "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
        },
        "file_sidang_skripsi": {
          "nama_file": "sidang-1412170002.pdf",
          "url": "fileSidang/sidang-1412170002.pdf"
        },
        "status_sidang_skripsi": "Sedang Berlangsung",
        "waktu_sidang_skripsi": "2021-06-01 09:00:00",
        "tanggal_pengajuan_sidang_skripsi": "2021-05-30 05:57:45"
      },
      {
        "id": 3,
        "mahasiswa": {
          "id": 2,
          "npm_mahasiswa": "1412170001",
          "nama_mahasiswa": "Kukoh Santoso"
        },
        "judul_skripsi": {
          "id": 5,
          "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
        },
        "file_sidang_skripsi": {
          "nama_file": "sidang-1412170001.pdf",
          "url": "fileSidang/sidang-1412170001.pdf"
        },
        "status_sidang_skripsi": "Selesai",
        "waktu_sidang_skripsi": "2021-05-29 09:00:00",
        "tanggal_pengajuan_sidang_skripsi": "2021-05-29 18:31:20"
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Login-->

  <!-- Fakultas By ID -->
  <section class="docs-section pt-3" id="item-19-2">
    <h3 class="section-heading">Sidang Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/sidangskripsi/{id}</small>
    </h4>
    <p>
      Melihat Data Sidang Skripsi Berdasarkan ID
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
      "id": 3,
      "mahasiswa": {
        "id": 2,
        "npm_mahasiswa": "1412170001",
        "nama_mahasiswa": "Kukoh Santoso"
      },
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "pembimbing1_sidang_skripsi": "Andy Haryoko, ST.,M.T.",
      "pembimbing2_sidang_skripsi": "Asfan Muqtadir, S.Kom.,M.Kom",
      "penguji1_sidang_skripsi": "Aris Wijayanti, S.T.,M.T.",
      "penguji2_sidang_skripsi": "Fitroh Amaluddin, S.T.,M.T."
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-19-3">
    <h3 class="section-heading">Tentukan Waktu Sidang</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/sidangskripsi/{id}</small>
    </h4>
    <p>
      Proses Mementukan Waktu, dan Tempat Sidang Skripsi.
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
        <h5>_method
          <small>
            <sup class="text-danger">* required</sup> string <b>value : PATCH</b>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>waktu_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> datetime
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> string
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
    "message": "The time has been determined successfully",
    "data": {
      "id": 4,
      "mahasiswa": {
        "id": 3,
        "npm_mahasiswa": "Maimunah"
      },
      "judul_skripsi": {
        "id": 7,
        "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
      },
      "waktu_sidang_skripsi": "2021-07-01 09:00:00",
      "tempat_sidang_skripsi": "Lab Jarkom",
      "updated_at": "2021-06-28T14:03:11Z"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-19-4">
    <h3 class="section-heading">Hasil Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/sidangskripsi/{id}/hasil</small>
    </h4>
    <p>
      Melihat hasil verifikasi pelaksanaan Sidang Skripsi oleh dosen dosen penguji dan dosen pembimbing.
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
    "message": "Details Data Hasil Sidang",
    "data": [
      {
        "id": 1,
        "nama_dosen_sidang_skripsi": "Andy Haryoko, ST.,M.T.",
        "status_dosen_sidang_skripsi": "Pembimbing 1",
        "status_verifikasi_dosen_sidang_skripsi": "Lulus Sidang"
      },
      {
        "id": 2,
        "nama_dosen_sidang_skripsi": "Asfan Muqtadir, S.Kom.,M.Kom",
        "status_dosen_sidang_skripsi": "Pembimbing 2",
        "status_verifikasi_dosen_sidang_skripsi": "Lulus Sidang"
      },
      {
        "id": 3,
        "nama_dosen_sidang_skripsi": "Aris Wijayanti, S.T.,M.T.",
        "status_dosen_sidang_skripsi": "Penguji 1",
        "status_verifikasi_dosen_sidang_skripsi": "Lulus Sidang"
      },
      {
        "id": 4,
        "nama_dosen_sidang_skripsi": "Fitroh Amaluddin, S.T.,M.T.",
        "status_dosen_sidang_skripsi": "Penguji 2",
        "status_verifikasi_dosen_sidang_skripsi": "Lulus Sidang"
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

    <!-- Tambah Fakultas  -->
    <section class="docs-section pt-3" id="item-19-5">
      <h3 class="section-heading">Verifikasi Sidang Skripsis </h3>
      <h4>
        <span class="badge badge-primary">POST</span>
        <small>adminprodi/sidangskripsi/{id}/verifikasi</small>
      </h4>
      <p>
        Proses verifikasi Sidang Skripsis selesai setelah status verifikasi dari dosen pembimbing dan dosen penguji dinyatakan lulus sidang.
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
          <h5>_method
            <small>
              <sup class="text-danger">* required</sup> string <b>value : PATCH</b>
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
    "message": "Verification of the sidang skripsi with id 3 was successful"
  }
                  </code>
                </pre>
      </div>
      <!-- Akhir Response -->

    </section>
    <!--//section Tambah -->

  </section>
  <!--//section Tambah -->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-19-6">
    <h3 class="section-heading">Nilai Sidang Skripsi </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/sidangskripsi/{id}/daftarnilai</small>
    </h4>
    <p>
      Setelah verifikasi oleh dosen pembimbing dan dosen penguji dinyatakan lulus sidang dan sudah dilakukan input nilai, admin prodi dapat melihat laporan nilai Sidang Skripsi yang telah dilaksanakan.
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
      "nilai_pembimbing1": {
        "dosen": {
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704"
        },
        "nilai_a": {
          "deskripsi_nilai_a_hasil_sidang_skripsi": "Nilai Pembimbingan Proposal",
          "nilai_a1_hasil_sidang_skripsi": 98,
          "nilai_a2_hasil_sidang_skripsi": 87,
          "nilai_a3_hasil_sidang_skripsi": 86,
          "jumlah_nilai_a_hasil_sidang_skripsi": 271,
          "rata2_nilai_a_hasil_sidang_skripsi": 90
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_sidang_skripsi": "Nilai Naskah Skripsi",
          "nilai_b1_hasil_sidang_skripsi": 92,
          "nilai_b2_hasil_sidang_skripsi": 96,
          "nilai_b3_hasil_sidang_skripsi": 85,
          "nilai_b4_hasil_sidang_skripsi": 86,
          "nilai_b5_hasil_sidang_skripsi": 84,
          "nilai_b6_hasil_sidang_skripsi": 78,
          "nilai_b7_hasil_sidang_skripsi": 82,
          "jumlah_nilai_b_hasil_sidang_skripsi": 603,
          "rata2_nilai_b_hasil_sidang_skripsi": 87
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_sidang_skripsi": "Nilai Pelaksanaan Sidang Skripsi",
          "nilai_c1_hasil_sidang_skripsi": 80,
          "nilai_c2_hasil_sidang_skripsi": 84,
          "nilai_c3_hasil_sidang_skripsi": 89,
          "jumlah_nilai_c_hasil_sidang_skripsi": 253,
          "rata2_nilai_c_hasil_sidang_skripsi": 85
        }
      },
      "nilai_pembimbing2": {
        "dosen": {
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905"
        },
        "nilai_a": {
          "deskripsi_nilai_a_hasil_sidang_skripsi": "Nilai Pembimbingan Proposal",
          "nilai_a1_hasil_sidang_skripsi": 98,
          "nilai_a2_hasil_sidang_skripsi": 97,
          "nilai_a3_hasil_sidang_skripsi": 86,
          "jumlah_nilai_a_hasil_sidang_skripsi": 281,
          "rata2_nilai_a_hasil_sidang_skripsi": 94
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_sidang_skripsi": "Nilai Naskah Skripsi",
          "nilai_b1_hasil_sidang_skripsi": 92,
          "nilai_b2_hasil_sidang_skripsi": 96,
          "nilai_b3_hasil_sidang_skripsi": 85,
          "nilai_b4_hasil_sidang_skripsi": 86,
          "nilai_b5_hasil_sidang_skripsi": 89,
          "nilai_b6_hasil_sidang_skripsi": 87,
          "nilai_b7_hasil_sidang_skripsi": 82,
          "jumlah_nilai_b_hasil_sidang_skripsi": 617,
          "rata2_nilai_b_hasil_sidang_skripsi": 89
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_sidang_skripsi": "Nilai Pelaksanaan Sidang Skripsi",
          "nilai_c1_hasil_sidang_skripsi": 80,
          "nilai_c2_hasil_sidang_skripsi": 84,
          "nilai_c3_hasil_sidang_skripsi": 89,
          "jumlah_nilai_c_hasil_sidang_skripsi": 253,
          "rata2_nilai_c_hasil_sidang_skripsi": 85
        }
      },
      "nilai_penguji1": {
        "dosen": {
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402"
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_sidang_skripsi": "Nilai Naskah Skripsi",
          "nilai_b1_hasil_sidang_skripsi": 92,
          "nilai_b2_hasil_sidang_skripsi": 96,
          "nilai_b3_hasil_sidang_skripsi": 85,
          "nilai_b4_hasil_sidang_skripsi": 86,
          "nilai_b5_hasil_sidang_skripsi": 89,
          "nilai_b6_hasil_sidang_skripsi": 87,
          "nilai_b7_hasil_sidang_skripsi": 82,
          "jumlah_nilai_b_hasil_sidang_skripsi": 617,
          "rata2_nilai_b_hasil_sidang_skripsi": 89
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_sidang_skripsi": "Nilai Pelaksanaan Sidang Skripsi",
          "nilai_c1_hasil_sidang_skripsi": 92,
          "nilai_c2_hasil_sidang_skripsi": 98,
          "nilai_c3_hasil_sidang_skripsi": 89,
          "jumlah_nilai_c_hasil_sidang_skripsi": 279,
          "rata2_nilai_c_hasil_sidang_skripsi": 94
        }
      },
      "nilai_penguji2": {
        "dosen": {
          "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
          "nidn_dosen": "0714048502"
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_sidang_skripsi": "Nilai Naskah Skripsi",
          "nilai_b1_hasil_sidang_skripsi": 92,
          "nilai_b2_hasil_sidang_skripsi": 96,
          "nilai_b3_hasil_sidang_skripsi": 85,
          "nilai_b4_hasil_sidang_skripsi": 86,
          "nilai_b5_hasil_sidang_skripsi": 96,
          "nilai_b6_hasil_sidang_skripsi": 87,
          "nilai_b7_hasil_sidang_skripsi": 82,
          "jumlah_nilai_b_hasil_sidang_skripsi": 624,
          "rata2_nilai_b_hasil_sidang_skripsi": 90
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_sidang_skripsi": "Nilai Pelaksanaan Sidang Skripsi",
          "nilai_c1_hasil_sidang_skripsi": 92,
          "nilai_c2_hasil_sidang_skripsi": 98,
          "nilai_c3_hasil_sidang_skripsi": 95,
          "jumlah_nilai_c_hasil_sidang_skripsi": 285,
          "rata2_nilai_c_hasil_sidang_skripsi": 96
        }
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

  </section>
  <!--//section Tambah -->

</article>