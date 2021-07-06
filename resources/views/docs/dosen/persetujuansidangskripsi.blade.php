<article class="docs-article" id="section-34">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Persetujuan Sidang Skripsi</h1>
    <p>
      Proses Verifikasi Persetujuan Pelaksaaan Sidang Skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-34-1">
    <h3 class="section-heading">Lihat Data Persetujuan Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuansidang</small>
    </h4>
    <p>
      Melihat semua data Persetujuan Pelaksanaan Sidang Skripsi
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
    "message": "List of Data Persetujuan Sidang Skripsi",
    "data": [
        {
            "id": 7,
            "mahasiswa": {
                "id": 12,
                "npm_mahasiswa": "1412160002",
                "nama_mahasiswa": "SHINTA WIDAYATI PUTRI"
            },
            "judul_skripsi": {
                "id": 12,
                "nama_judul_skripsi": "Indonesia Raya"
            },
            "file_persetujuan_sidang": {
                "nama_file": "sidang-1412160002.pdf",
                "url": "fileSidang/sidang-1412160002.pdf"
            },
            "status_persetujuan_sidang": "Disetujui",
            "catatan_persetujuan_sidang": "Nulla qui cillum ipsum pariatur voluptate veniam anim anim deserunt.",
            "tanggal_pengajuan_persetujuan_sidang": "2021-07-02 23:54:22"
        },
        {
            "id": 2,
            "mahasiswa": {
                "id": 13,
                "npm_mahasiswa": "1412170001",
                "nama_mahasiswa": "Kukoh Santoso"
            },
            "judul_skripsi": {
                "id": 12,
                "nama_judul_skripsi": "Perangcangan dan Implementasi Metode XXXX dalam XXX"
            },
            "file_persetujuan_sidang": {
                "nama_file": "sidang-1412170001.pdf",
                "url": "fileSidang/sidang-1412170001.pdf"
            },
            "status_persetujuan_sidang": "Disetujui",
            "catatan_persetujuan_sidang": "Eiusmod consequat Lorem aliquip culpa duis nisi aliquip ullamco pariatur cillum ea reprehenderit.",
            "tanggal_pengajuan_persetujuan_sidang": "2021-07-02 23:54:22"
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
  <section class="docs-section pt-3" id="item-34-2">
    <h3 class="section-heading">Persetujuan Sidang Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuansidang/{id}</small>
    </h4>
    <p>
      Melihat Data Persetujuan Sidang Skripsi Berdasarkan ID
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
  "message": "Details Data Persetujuan Sidang",
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
    "file_persetujuan_sidang": {
      "nama_file": "sidang-1412170001.pdf",
      "url": "fileSidang/sidang-1412170001.pdf"
    },
    "status_persetujuan_sidang": "Antrian",
    "catatan_persetujuan_sidang": "Reprehenderit mollit mollit Lorem non laborum veniam nisi pariatur aute incididunt.",
    "tanggal_pengajuan_persetujuan_sidang": "2021-05-29 11:31:20"
  }
}
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-34-3">
    <h3 class="section-heading">Verifikasi Persetujuan Sidang Skripsi</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/persetujuansidang/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Persetujuan Pelaksanaan Sidang Skripsi
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
        <h5>status_persetujuan_sidang
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Ditolak')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_persetujuan_sidang
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
      "status_persetujuan_sidang": "Disetujui",
      "catatan_persetujuan_sidang": "Reprehenderit mollit mollit Lorem non laborum veniam nisi pariatur aute incididunt.",
      "updated_at": "2021-06-24T16:49:15Z"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->
</article>