<article class="docs-article" id="section-35">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Sidang Skripsi</h1>
    <p>
      Proses Verifikasi Pelaksaaan Sidang Skripsi dan Input Nilai Sidang Skripsi
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-35-1">
    <h3 class="section-heading">Lihat Data Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/sidangskripsi</small>
    </h4>
    <p>
      Melihat semua data Sidang Skripsi
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
        "jabatan_dosen_sidang_skripsi": "Pembimbing 2",
        "waktu_sidang_skripsi": "2021-06-01 09:00:00",
        "tempat_sidang_skripsi": "Lab Jarkom",
        "status_sidang_skripsi": "Sedang Berlangsung",
        "status_verifikasi_sidang_skripsi": "Belum Verifikasi"
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
        "jabatan_dosen_sidang_skripsi": "Pembimbing 1",
        "waktu_sidang_skripsi": "2021-05-29 09:00:00",
        "tempat_sidang_skripsi": "Lab Data Mining",
        "status_sidang_skripsi": "Selesai",
        "status_verifikasi_sidang_skripsi": "Lulus Sidang"
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
  <section class="docs-section pt-3" id="item-35-2">
    <h3 class="section-heading">Sidang Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/sidangskripsi/{id}</small>
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
      "file_sidang_skripsi": {
        "nama_file": "sidang-1412170001.pdf",
        "url": "fileSidang/sidang-1412170001.pdf"
      },
      "jabatan_dosen_sidang_skripsi": "Pembimbing 1",
      "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
      "catatan_hasil_sidang_skripsi": "Ut proident nostrud voluptate veniam occaecat laborum."
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-35-3">
    <h3 class="section-heading">Verifikasi Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/sidangskripsi/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Sidang Skripsi
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
        <h5>status_verifikasi_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> enum ('Revisi','Lulus Sidang')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_hasil_sidang_skripsi
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
    "message": "Verification is successful",
    "data": {
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
      "jabatan_dosen_sidang_skripsi": "Pembimbing 2",
      "status_verifikasi_hasil_sidang_skripsi": "Lulus Sidang",
      "catatan_hasil_sidang_skripsi": "Qui ea nostrud commodo aliquip proident ea eiusmod esse est.",
      "updated_at": "1 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-35-4">
    <h3 class="section-heading">Input Nilai Sidang Skripsi </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/sidangskripsi/{id}/nilai</small>
    </h4>
    <p>
      Setelah melakukan verifikasi bahwa mahasiswa yang bersangkutan dinyatakan <b>Lulus Sidang</b>, dosen dapat melakukan proses input nilai Sidang Skripsi.
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
        <h5>nilai_a1_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_a2_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_a3_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b1_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b2_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b3_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b4_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b5_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b6_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b7_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c1_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c2_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c3_hasil_sidang_skripsi
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
    </div>

    <!-- Keterangan Nilai -->
    <h5 class="mt-0">Keterangan Nilai:</h5>
    <div class="alert alert-info" role="alert">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>Nilai A</th>
            <th>
              Nilai Proses Bimbingan Skripsi (Khusus Dosen Pembimbing)
            </th>
          </tr>
          <tr>
            <th>A.1</th>
            <td>
              Ketekunan : Ketepatan waktu dalam pembimbingan
            </td>
          </tr>
          <tr>
            <th>A.2</th>
            <td>
              Adab : Kesopanan dan kejujuran selama proses bimbingan
            </td>
          </tr>
          <tr>
            <th>A.3</th>
            <td>
              Kemandirian : Kemandirian dalam mengerjakan skripsi
            </td>
          </tr>

          <tr>
            <th>Nilai B</th>
            <th>
              Nilai Naskah Skripsi
            </th>
          </tr>
          <tr>
            <th>B.1</th>
            <td>
              Teknik Penulisan : Meliputi sistematika penulisan dan kontribusi keilmuan, keterpaduan antar kalimat dan paragraf, tanda baca sesuai, cara mengkutip pendapat ahli benar, kalimat mudah dipahami.
            </td>
          </tr>
          <tr>
            <th>B.2</th>
            <td>
              Konsep Pemikiran : Meliputi original, kejelasan masalah/ rumusan masalah, tujuan penelitian, definisi operasional, hipotesis (jika ada)
            </td>
          </tr>
          <tr>
            <th>B.3</th>
            <td>
              Kajian Pustaka : Meliputi kesesuaian kajian pustaka/landasan teori dengan rumusan masalah dan tujuan penelitian.
            </td>
          </tr>
          <tr>
            <th>B.4</th>
            <td>
              Metode Penelitian : Meliputi desain dan rancangan penelitian, kelengkapan instrumen, teknik analisis data, prosedur penelitian.
            </td>
          </tr>
          <tr>
            <th>B.5</th>
            <td>
              Hasil dan Pembahasan : Meliputi keakuratan data, deskripsi jelas dan sistematis, kesesuaian dan kecermatan analisis data, pembahas-an penelitian sistematis dan relevan, mencakup keterkaitan hasil dan analisis data penelitian dengan rumusan masalah, kajian pustaka (posisi temuan/teori terhadap teori dan temuan sebelumnya serta penjelasan dari temuan yang diungkap dari lapangan), dan kelemahan penelitian (bila ada).
            </td>
          </tr>
          <tr>
            <th>B.6</th>
            <td>
              Kesimpulan Penelitian : Meliputi kesimpulan jelas, sistematis dan cermat, menjawab rumusan masalah/tujuan penelitian, saran teoritis dan aplikatif.
            </td>
          </tr>
          <tr>
            <th>B.7</th>
            <td>
              Kepustakaan : Meliputi relevansi dengan penelitian, keterkinian pustaka yang digunakan, jumlah referensi.
            </td>
          </tr>

          <tr>
            <th>Nilai C</th>
            <th>
              Nilai Pelaksanaan Sidang Skripsi
            </th>
          </tr>
          <tr>
            <th>C.1</th>
            <td>
              Presentasi dan Singkronisasi
            </td>
          </tr>
          <tr>
            <th>C.2</th>
            <td>
              Penguasaan Materi
            </td>
          </tr>
          <tr>
            <th>C.3</th>
            <td>
              Kemampuan Berargumentasi
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- //Keterangan Nilai  -->

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Input nilai is successful",
    "nilai_hasil_sidang_skripsi": {
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
      "jabatan_dosen_sidang_skripsi": "Pembimbing 2",
      "nilai_a1_hasil_sidang_skripsi": "90",
      "nilai_a2_hasil_sidang_skripsi": "98",
      "nilai_a3_hasil_sidang_skripsi": "92",
      "nilai_b1_hasil_sidang_skripsi": "92",
      "nilai_b2_hasil_sidang_skripsi": "96",
      "nilai_b3_hasil_sidang_skripsi": "85",
      "nilai_b4_hasil_sidang_skripsi": "86",
      "nilai_b5_hasil_sidang_skripsi": "96",
      "nilai_b6_hasil_sidang_skripsi": "87",
      "nilai_b7_hasil_sidang_skripsi": "82",
      "nilai_c1_hasil_sidang_skripsi": "92",
      "nilai_c2_hasil_sidang_skripsi": "98",
      "nilai_c3_hasil_sidang_skripsi": "95"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-35-5">
    <h3 class="section-heading">Lihat Nilai Sidang Skripsi </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/sidangskripsi/{id}/nilai</small>
    </h4>
    <p>
      Melihat Nilai Sidang Skripsi Yang Telah Diinput.
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
    "message": "Data information",
    "data": {
      "id": 3,
      "mahasiswa": {
        "id": 2,
        "npm_mahasiswa": "Kukoh Santoso"
      },
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "jabatan_dosen_sidang_skripsi": "Pembimbing 1",
      "nilai_a1_hasil_sidang_skripsi": 98,
      "nilai_a2_hasil_sidang_skripsi": 87,
      "nilai_a3_hasil_sidang_skripsi": 86,
      "nilai_b1_hasil_sidang_skripsi": 92,
      "nilai_b2_hasil_sidang_skripsi": 96,
      "nilai_b3_hasil_sidang_skripsi": 85,
      "nilai_b4_hasil_sidang_skripsi": 86,
      "nilai_b5_hasil_sidang_skripsi": 84,
      "nilai_b6_hasil_sidang_skripsi": 78,
      "nilai_b7_hasil_sidang_skripsi": 82,
      "nilai_c1_hasil_sidang_skripsi": 80,
      "nilai_c2_hasil_sidang_skripsi": 84,
      "nilai_c3_hasil_sidang_skripsi": 89
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

</article>