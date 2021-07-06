<article class="docs-article" id="section-32">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Seminar Proposal</h1>
    <p>
      Proses Verifikasi Pelaksaaan Seminar Proposal dan Input Nilai Seminar Proposal
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-32-1">
    <h3 class="section-heading">Lihat Data Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/seminarproposal</small>
    </h4>
    <p>
      Melihat semua data Seminar Proposal
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
    "message": "List of Data Seminar Proposal",
    "data": [
      {
        "id": 3,
        "mahasiswa": {
          "id": 3,
          "npm_mahasiswa": "1412170002",
          "nama_mahasiswa": "Maimunah"
        },
        "judul_skripsi": {
          "id": 7,
          "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
        },
        "file_seminar_proposal": {
          "nama_file": "seminar-1412170002.pdf",
          "url": "fileSeminar/seminar-1412170002.pdf"
        },
        "jabatan_dosen_seminar_proposal": "Pembimbing 2",
        "waktu_seminar_proposal": "2021-05-28 08:00:00",
        "tempat_seminar_proposal": "Lab Data Mining",
        "status_seminar_proposal": "Belum Mulai",
        "status_verifikasi_seminar_proposal": "Belum Verifikasi"
      },
      {
        "id": 4,
        "mahasiswa": {
          "id": 5,
          "npm_mahasiswa": "1412170004",
          "nama_mahasiswa": "Ali Ghufron"
        },
        "judul_skripsi": {
          "id": 8,
          "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"
        },
        "file_seminar_proposal": {
          "nama_file": "seminar-1412170004.pdf",
          "url": "fileSeminar/seminar-1412170004.pdf"
        },
        "jabatan_dosen_seminar_proposal": "Penguji 1",
        "waktu_seminar_proposal": "2021-06-26 09:00:00",
        "tempat_seminar_proposal": "Lab Data Mining",
        "status_seminar_proposal": "Sedang Berlangsung",
        "status_verifikasi_seminar_proposal": "Revisi"
      },
      {
        "id": 2,
        "mahasiswa": {
          "id": 2,
          "npm_mahasiswa": "1412170001",
          "nama_mahasiswa": "Kukoh Santoso"
        },
        "judul_skripsi": {
          "id": 5,
          "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
        },
        "file_seminar_proposal": {
          "nama_file": "seminar-1412170001.pdf",
          "url": "fileSeminar/seminar-1412170001.pdf"
        },
        "jabatan_dosen_seminar_proposal": "Pembimbing 1",
        "waktu_seminar_proposal": "2021-05-27 08:00:00",
        "tempat_seminar_proposal": "Lab Data Mining",
        "status_seminar_proposal": "Selesai",
        "status_verifikasi_seminar_proposal": "Lulus Seminar"
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
  <section class="docs-section pt-3" id="item-32-2">
    <h3 class="section-heading">Seminar Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/seminarproposal/{id}</small>
    </h4>
    <p>
      Melihat Data Seminar Proposal Berdasarkan ID
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
    "message": "Details Data Seminar Proposal",
    "data": {
      "id": 3,
      "mahasiswa": {
        "id": 3,
        "npm_mahasiswa": "1412170002",
        "nama_mahasiswa": "Maimunah"
      },
      "judul_skripsi": {
        "id": 7,
        "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
      },
      "file_seminar_proposal": {
        "nama_file": "seminar-1412170002.pdf",
        "url": "fileSeminar/seminar-1412170002.pdf"
      },
      "jabatan_dosen_seminar_proposal": "Pembimbing 2",
      "status_verifikasi_hasil_seminar_proposal": "Lulus Seminar",
      "catatan_hasil_seminar_proposal": "-"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-32-3">
    <h3 class="section-heading">Verifikasi Seminar Proposal</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/seminarproposal/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Seminar Proposal
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
        <h5>status_verifikasi_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> enum ('Revisi','Lulus Seminar')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_hasil_seminar_proposal
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
        "id": 5,
        "npm_mahasiswa": "1412170004",
        "nama_mahasiswa": "Ali Ghufron"
      },
      "judul_skripsi": {
        "id": 8,
        "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"
      },
      "jabatan_dosen_seminar_proposal": "Pembimbing 2",
      "status_verifikasi_hasil_seminar_proposal": "Lulus Seminar",
      "catatan_hasil_seminar_proposal": "Sint duis qui dolore elit exercitation incididunt ex nostrud quis culpa commodo fugiat.",
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
  <section class="docs-section pt-3" id="item-32-4">
    <h3 class="section-heading">Input Nilai Seminar Proposal </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/seminarproposal/{id}/nilai</small>
    </h4>
    <p>
      Setelah melakukan verifikasi bahwa mahasiswa yang bersangkutan dinyatakan <b>Lulus Seminar</b>, dosen dapat melakukan proses input nilai seminar proposal.
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
        <h5>nilai_a1_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_a2_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_a3_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required (khusus dosen pembimbing)</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b1_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b2_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b3_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b4_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b5_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b6_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_b7_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c1_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c2_hasil_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> numeric (1 s/d 100)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nilai_c3_hasil_seminar_proposal
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
              Nilai Proses Bimbingan Proposal (Khusus Dosen Pembimbing)
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
              Nilai Naskah Proposal
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
              Nilai Pelaksanaan Seminar Proposal
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
    "data": {
      "id": 4,
      "mahasiswa": {
        "id": 5,
        "npm_mahasiswa": "1412170004",
        "nama_mahasiswa": "Ali Ghufron"
      },
      "judul_skripsi": {
        "id": 8,
        "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"
      },
      "jabatan_dosen_seminar_proposal": "Penguji 1",
      "nilai_a1_hasil_seminar_proposal": null,
      "nilai_a2_hasil_seminar_proposal": null,
      "nilai_a3_hasil_seminar_proposal": null,
      "nilai_b1_hasil_seminar_proposal": "87",
      "nilai_b2_hasil_seminar_proposal": "84",
      "nilai_b3_hasil_seminar_proposal": "85",
      "nilai_b4_hasil_seminar_proposal": "86",
      "nilai_b5_hasil_seminar_proposal": "84",
      "nilai_b6_hasil_seminar_proposal": "78",
      "nilai_b7_hasil_seminar_proposal": "82",
      "nilai_c1_hasil_seminar_proposal": "80",
      "nilai_c2_hasil_seminar_proposal": "84",
      "nilai_c3_hasil_seminar_proposal": "89"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-32-5">
    <h3 class="section-heading">Lihat Nilai Seminar Proposal </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/seminarproposal/{id}/nilai</small>
    </h4>
    <p>
      Melihat Nilai Seminar Proposal Yang Telah Diinput.
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
        "id": 3,
        "npm_mahasiswa": "Maimunah"
      },
      "judul_skripsi": {
        "id": 7,
        "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
      },
      "jabatan_dosen_seminar_proposal": "Pembimbing 2",
      "nilai_a1_hasil_seminar_proposal": 90,
      "nilai_a2_hasil_seminar_proposal": 96,
      "nilai_a3_hasil_seminar_proposal": 86,
      "nilai_b1_hasil_seminar_proposal": 94,
      "nilai_b2_hasil_seminar_proposal": 95,
      "nilai_b3_hasil_seminar_proposal": 85,
      "nilai_b4_hasil_seminar_proposal": 86,
      "nilai_b5_hasil_seminar_proposal": 84,
      "nilai_b6_hasil_seminar_proposal": 78,
      "nilai_b7_hasil_seminar_proposal": 82,
      "nilai_c1_hasil_seminar_proposal": 80,
      "nilai_c2_hasil_seminar_proposal": 84,
      "nilai_c3_hasil_seminar_proposal": 89
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

</article>