<article class="docs-article" id="section-30">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Bimbingan Proposal</h1>
    <p>
      Proses verifikasi bimbingan proposal skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-30-1">
    <h3 class="section-heading">Lihat Data Bimbingan Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/bimbinganproposal</small>
    </h4>
    <p>
      Melihat semua data bimbingan proposal skripsi
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
    "message": "List of Data Bimbingan Proposal",
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
        "file_bimbingan_proposal": {
          "nama_file": "proposal-1412170002_05242021185515.pdf",
          "url": "fileProposal/proposal-1412170002_05242021185515.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 1",
        "status_persetujuan_bimbingan_proposal": "Antrian",
        "catatan_bimbingan_proposal": null,
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 18:55:15"
      },
      {
        "id": 9,
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
          "nama_file": "proposal-1412170001_05242021175703.pdf",
          "url": "fileProposal/proposal-1412170001_05242021175703.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 3",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "Sint enim ipsum nisi aute quis.",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 17:57:03"
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
          "nama_file": "proposal-1412170001_05242021161816.pdf",
          "url": "fileProposal/proposal-1412170001_05242021161816.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 2",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "-",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 16:18:16"
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
          "nama_file": "proposal-1412170001_05242021161610.pdf",
          "url": "fileProposal/proposal-1412170001_05242021161610.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 1",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "-",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 16:16:10"
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
  <section class="docs-section pt-3" id="item-30-2">
    <h3 class="section-heading">Bimbingan Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/bimbinganproposal/{id}</small>
    </h4>
    <p>
      Melihat Data Bimbingan Proposal Berdasarkan ID
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
    "message": "Details Data Bimbingan Proposal",
    "data": {
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
      "topik_bimbingan_proposal": "Bimbingan BAB 1",
      "file_bimbingan_proposal": {
        "nama_file": "proposal-1412170001_05242021161610.pdf",
        "url": "fileProposal/proposal-1412170001_05242021161610.pdf"
      },
      "status_persetujuan_bimbingan_proposal": "Disetujui",
      "catatan_bimbingan_proposal": "Excepteur ex consequat labore ut sunt fugiat reprehenderit cillum velit aliqua sit proident est.",
      "tanggal_persetujuan_bimbingan_proposal": "2021-06-25 00:56:02"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-30-3">
    <h3 class="section-heading">Verifikasi Bimbingan Proposal</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/bimbinganproposal/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Bimbingan Proposal
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
        <h5>status_persetujuan_bimbingan_proposal
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Revisi')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_bimbingan_proposal
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
    "message": "Cerification is successful",
    "data": {
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
      "topik_bimbingan_proposal": "Bimbingan BAB 1",
      "status_bimbingan_proposal": "Disetujui",
      "catatan_bimbingan_proposal": "Minim exercitation sint et dolore incididunt magna ex duis.",
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