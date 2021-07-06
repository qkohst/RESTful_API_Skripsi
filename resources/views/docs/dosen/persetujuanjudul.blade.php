<article class="docs-article" id="section-28">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Persetujuan Judul</h1>
    <p>
      Proses verifikasi judul skripsi yang telah diajukan oleh mahasiswa.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-28-1">
    <h3 class="section-heading">Lihat Data Persetujuan Judul</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuanjudul</small>
    </h4>
    <p>
      Melihat semua data Persetujuan Judul Skripsi Mahasiswa
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
    "message": "List of Data Persetujuan Judul",
    "data": [
      {
        "id": 10,
        "mahasiswa": {
          "id": 3,
          "npm_mahasiswa": "1412170002",
          "nama_mahasiswa": "Maimunah"
        },
        "judul_skripsi": {
          "id": 7,
          "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
        },
        "jabatan_dosen_pembimbing": "Pembimbing 2",
        "persetujuan_dosen_pembimbing": "Antrian",
        "catatan_dosen_pembimbing": null,
        "tanggal_pengajuan_dosen_pembimbing": "2021-05-24 18:39:54"
      },
      {
        "id": 5,
        "mahasiswa": {
          "id": 2,
          "npm_mahasiswa": "1412170001",
          "nama_mahasiswa": "Kukoh Santoso"
        },
        "judul_skripsi": {
          "id": 5,
          "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
        },
        "jabatan_dosen_pembimbing": "Pembimbing 1",
        "persetujuan_dosen_pembimbing": "Disetujui",
        "catatan_dosen_pembimbing": "Sunt voluptate ullamco eu occaecat excepteur adipisicing deserunt qui qui aute.",
        "tanggal_pengajuan_dosen_pembimbing": "2021-05-14 22:17:58"
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
  <section class="docs-section pt-3" id="item-28-2">
    <h3 class="section-heading">Persetujuan Judul By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/persetujuanjudul/{id}</small>
    </h4>
    <p>
      Melihat Data Persetujuan Judul Skripsi Berdasarkan ID
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
  "message": "Details Data Persetujuan Judul",
  "data": {
    "id": 10,
    "mahasiswa": {
      "id": 3,
      "npm_mahasiswa": "1412170002",
      "nama_mahasiswa": "Maimunah"
    },
    "judul_skripsi": {
      "id": 7,
      "nama_judul_skripsi": "Penerapan Metode XXX Dalam XXXX"
    },
    "jabatan_dosen_pembimbing": "Pembimbing 2",
    "persetujuan_dosen_pembimbing": "Disetujui",
    "catatan_dosen_pembimbing": "Eiusmod velit amet ipsum duis Lorem fugiat."
  }
}
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-28-3">
    <h3 class="section-heading">Verifikasi Judul</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/persetujuanjudul/{id}</small>
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
        <h5>persetujuan_dosen_pembimbing
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Ditolak')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_dosen_pembimbing
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
        "id": 18,
        "mahasiswa": {
            "id": 12,
            "npm_mahasiswa": "1412160002",
            "nama_mahasiswa": "SHINTA WIDAYATI PUTRI"
        },
        "judul_skripsi": {
            "id": 12,
            "nama_judul_skripsi": "Indonesia Raya"
        },
        "jabatan_dosen_pembimbing": "1",
        "persetujuan_dosen_pembimbing": "Disetujui",
        "catatan_dosen_pembimbing": "Sit adipisicing cillum eu veniam mollit anim et nostrud deserunt eu labore in reprehenderit.",
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