<article class="docs-article" id="section-33">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Bimbingan Skripsi</h1>
    <p>
      Proses verifikasi bimbingan Skripsi skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-33-1">
    <h3 class="section-heading">Lihat Data Bimbingan Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/bimbinganskripsi</small>
    </h4>
    <p>
      Melihat semua data bimbingan skripsi
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
    "message": "List of Data Bimbingan Skripsi",
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
        "file_bimbingan_proposal": {
          "nama_file": "skripsi-1412170002_05302021055624.pdf",
          "url": "fileSkripsi/skripsi-1412170002_05302021055624.pdf"
        },
        "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 1",
        "status_persetujuan_bimbingan_skripsi": "Antrian",
        "catatan_bimbingan_skripsi": null,
        "tanggal_pengajuan_bimbingan_skripsi": "2021-05-30 05:56:24",
        "tanggal_persetujuan_bimbingan_skripsi": null
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
        "file_bimbingan_proposal": {
          "nama_file": "skripsi-1412170001_05292021151632.pdf",
          "url": "fileSkripsi/skripsi-1412170001_05292021151632.pdf"
        },
        "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 2",
        "status_persetujuan_bimbingan_skripsi": "Disetujui",
        "catatan_bimbingan_skripsi": "Cillum dolor tempor eiusmod voluptate cillum ea proident ea exercitation ut.",
        "tanggal_pengajuan_bimbingan_skripsi": "2021-05-29 15:16:32",
        "tanggal_persetujuan_bimbingan_skripsi": "2021-05-29 17:55:31"
      },
      {
        "id": 1,
        "mahasiswa": {
          "id": 2,
          "npm_mahasiswa": "1412170001",
          "nama_mahasiswa": "Kukoh Santoso"
        },
        "judul_skripsi": {
          "id": 5,
          "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
        },
        "file_bimbingan_proposal": {
          "nama_file": "skripsi-1412170001_05292021150750.pdf",
          "url": "fileSkripsi/skripsi-1412170001_05292021150750.pdf"
        },
        "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 1",
        "status_persetujuan_bimbingan_skripsi": "Disetujui",
        "catatan_bimbingan_skripsi": "-",
        "tanggal_pengajuan_bimbingan_skripsi": "2021-05-29 15:07:50",
        "tanggal_persetujuan_bimbingan_skripsi": "2021-05-29 15:07:50"
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
  <section class="docs-section pt-3" id="item-33-2">
    <h3 class="section-heading">Bimbingan Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/bimbinganskripsi/{id}</small>
    </h4>
    <p>
      Melihat Data Bimbingan Skripsi Berdasarkan ID
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
    "message": "Details Data Bimbingan Skripsi",
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
      "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 2",
      "file_bimbingan_skripsi": {
        "nama_file": "skripsi-1412170001_05292021151632.pdf",
        "url": "fileSkripsi/skripsi-1412170001_05292021151632.pdf"
      },
      "status_persetujuan_bimbingan_skripsi": "Disetujui",
      "catatan_bimbingan_skripsi": "Cillum dolor tempor eiusmod voluptate cillum ea proident ea exercitation ut.",
      "tanggal_persetujuan_bimbingan_skripsi": "2021-05-29 17:55:31"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-33-3">
    <h3 class="section-heading">Verifikasi Bimbingan Skripsi</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/bimbinganskripsi/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Bimbingan Skripsi
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
        <h5>status_persetujuan_bimbingan_skripsi
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Revisi')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_bimbingan_skripsi
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
      "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 2",
      "status_bimbingan_skripsi": "Disetujui",
      "catatan_bimbingan_skripsi": "Cillum dolor tempor eiusmod voluptate cillum ea proident ea exercitation ut.",
      "updated_at": "1 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->
</article>