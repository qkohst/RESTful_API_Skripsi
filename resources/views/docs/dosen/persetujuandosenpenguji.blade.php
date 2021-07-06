<article class="docs-article" id="section-29">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Persetujuan Dosen Penguji</h1>
    <p>
      Proses verifikasi persetujuan sebagai dosen penguji.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-29-1">
    <h3 class="section-heading">Lihat Data Persetujuan Dosen Penguji</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuandosenpenguji</small>
    </h4>
    <p>
      Melihat semua data Persetujuan Dosen Penguji
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
    "message": "List of Data Persetujuan Dosen Penguji",
    "data": [
      {
        "id": 8,
        "mahasiswa": {
          "id": 5,
          "npm_mahasiswa": "1412170004",
          "nama_mahasiswa": "Ali Ghufron"
        },
        "judul_skripsi": {
          "id": 8,
          "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"
        },
        "seminar_proposal": {
          "id": 4,
          "tempat_seminar_proposal": "Lab Data Mining",
          "waktu_seminar_proposal": "2021-05-31 09:00:00"
        },
        "jabatan_dosen_penguji": "Penguji 2",
        "status_persetujuan_dosen_penguji": "Antrian",
        "tanggal_pengajuan_dosen_penguji": "2021-05-28T00:06:31Z"
      },
      {
        "id": 5,
        "mahasiswa": {
          "id": 3,
          "npm_mahasiswa": "1412170002",
          "nama_mahasiswa": "Maimunah"
        },
        "judul_skripsi": {
          "id": 7,
          "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
        },
        "seminar_proposal": {
          "id": 3,
          "tempat_seminar_proposal": "Lab Data Mining",
          "waktu_seminar_proposal": "2021-05-28 08:00:00"
        },
        "jabatan_dosen_penguji": "Penguji 1",
        "status_persetujuan_dosen_penguji": "Disetujui",
        "tanggal_pengajuan_dosen_penguji": "2021-05-27T20:48:59Z"
      },
      {
        "id": 4,
        "mahasiswa": {
          "id": 2,
          "npm_mahasiswa": "1412170001",
          "nama_mahasiswa": "Kukoh Santoso"
        },
        "judul_skripsi": {
          "id": 5,
          "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
        },
        "seminar_proposal": {
          "id": 2,
          "tempat_seminar_proposal": "Lab Data Mining",
          "waktu_seminar_proposal": "2021-05-27 08:00:00"
        },
        "jabatan_dosen_penguji": "Penguji 2",
        "status_persetujuan_dosen_penguji": "Disetujui",
        "tanggal_pengajuan_dosen_penguji": "2021-05-27T20:46:24Z"
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
  <section class="docs-section pt-3" id="item-29-2">
    <h3 class="section-heading">Persetujuan Dosen Penguji By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuandosenpenguji/{id}</small>
    </h4>
    <p>
      Melihat Data Persetujuan Dosen Penguji Berdasarkan ID
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
    "message": "Details Data Persetujuan Dosen Penguji",
    "data": {
      "id": 8,
      "mahasiswa": {
        "id": 5,
        "npm_mahasiswa": "1412170004",
        "nama_mahasiswa": "Ali Ghufron"
      },
      "judul_skripsi": {
        "id": 8,
        "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"
      },
      "seminar_proposal": {
        "id": 4,
        "tempat_seminar_proposal": "Lab Data Mining",
        "waktu_seminar_proposal": "2021-05-31 09:00:00"
      },
      "jabatan_dosen_penguji": "Penguji 2",
      "status_persetujuan_dosen_penguji": "Disetujui"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-29-3">
    <h3 class="section-heading">Verifikasi Dosen Penguji</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/persetujuandosenpenguji/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Judul Skripsi
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
        <h5>status_persetujuan_dosen_penguji
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Ditolak')
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
        "seminar_proposal": {
            "id": 2,
            "tempat_seminar_proposal": "Lab Data Mining",
            "waktu_seminar_proposal": "2021-05-27 08:00:00"
        },
        "jabatan_dosen_penguji": "1",
        "status_persetujuan_dosen_penguji": "Disetujui"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->
</article>