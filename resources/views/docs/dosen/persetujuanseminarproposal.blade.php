<article class="docs-article" id="section-31">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Persetujuan Seminar Proposal</h1>
    <p>
      Proses Verifikasi Persetujuan Pelaksaaan Seminar Proposal.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-31-1">
    <h3 class="section-heading">Lihat Data Persetujuan Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuanseminar</small>
    </h4>
    <p>
      Melihat semua data Persetujuan Pelaksanaan Seminar Proposal
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
    "message": "List of Data Persetujuan Seminar Proposal",
    "data": [
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
        "file_persetujuan_seminar": {
          "nama_file": "seminar-1412170001.pdf",
          "url": "fileSeminar/seminar-1412170001.pdf"
        },
        "status_persetujuan_seminar": "Antrian",
        "catatan_persetujuan_seminar": null,
        "tanggal_pengajuan_persetujuan_seminar": "2021-05-22 14:43:08"
      },
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
        "file_persetujuan_seminar": {
          "nama_file": "seminar-1412170002.pdf",
          "url": "fileSeminar/seminar-1412170002.pdf"
        },
        "status_persetujuan_seminar": "Disetujui",
        "catatan_persetujuan_seminar": "Magna mollit aliquip fugiat ipsum adipisicing ullamco dolor sunt consectetur irure officia enim proident.",
        "tanggal_pengajuan_persetujuan_seminar": "2021-05-24 18:56:29"
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
  <section class="docs-section pt-3" id="item-31-2">
    <h3 class="section-heading">Persetujuan Seminar Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuanseminar/{id}</small>
    </h4>
    <p>
      Melihat Data Persetujuan Seminar Proposal Berdasarkan ID
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
    "message": "Details Data Persetujuan Seminar",
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
      "file_persetujuan_seminar": {
        "nama_file": "seminar-1412170002.pdf",
        "url": "fileSeminar/seminar-1412170002.pdf"
      },
      "status_persetujuan_seminar": "Disetujui",
      "catatan_persetujuan_seminar": "Reprehenderit officia ipsum Lorem amet ex aliquip nisi minim consequat veniam minim.",
      "tanggal_pengajuan_persetujuan_seminar": "2021-05-24 18:56:29"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-31-3">
    <h3 class="section-heading">Verifikasi Persetujuan Seminar Proposal</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/persetujuanseminar/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Persetujuan Pelaksanaan Seminar Proposal
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
        <h5>status_persetujuan_seminar
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Ditolak')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_persetujuan_seminar
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
      "status_persetujuan_seminar": "Disetujui",
      "catatan_persetujuan_seminar": "Lorem labore excepteur irure reprehenderit minim sunt amet fugiat dolore sunt.",
      "updated_at": "2021-06-24 12:55:00"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->
</article>