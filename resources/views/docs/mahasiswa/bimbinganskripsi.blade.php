<article class="docs-article" id="section-25">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Bimbingan Skripsi</h1>
    <p>
      Setelah tahap Seminar Proposal selesai, mahasiswa dapat melanjutkan pada proses bimbingan skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-25-1">
    <h3 class="section-heading">Lihat Data Bimbingan Skripsi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/bimbinganskripsi</small>
    </h4>
    <p>
      Melihat semua data bimbingan skripsi skripsi mahasiswa.
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
        "id": 2,
        "dosen_pembimbing": {
          "id": 5,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "jabatan_dosen_pembimbing": "Pembimbing 1"
        },
        "file_bimbingan_skripsi": {
          "nama_file": "skripsi-1412170001_05292021151632.pdf",
          "url": "fileSkripsi/skripsi-1412170001_05292021151632.pdf"
        },
        "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 2",
        "status_persetujuan_bimbingan_skripsi": "Disetujui",
        "catatan_bimbingan_skripsi": "Cillum dolor tempor eiusmod voluptate cillum ea proident ea exercitation ut.",
        "tanggal_pengajuan_bimbingan_skripsi": "2021-05-29 15:16:32"
      },
      {
        "id": 1,
        "dosen_pembimbing": {
          "id": 5,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "jabatan_dosen_pembimbing": "Pembimbing 1"
        },
        "file_bimbingan_skripsi": {
          "nama_file": "skripsi-1412170001_05292021150750.pdf",
          "url": "fileSkripsi/skripsi-1412170001_05292021150750.pdf"
        },
        "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 1",
        "status_persetujuan_bimbingan_skripsi": "Disetujui",
        "catatan_bimbingan_skripsi": "Cillum deserunt et id aliquip mollit ea dolor non consequat aliqua deserunt.",
        "tanggal_pengajuan_bimbingan_skripsi": "2021-05-29 15:07:50"
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
  <section class="docs-section pt-3" id="item-25-2">
    <h3 class="section-heading">Pengajuan Bimbingan Skripsi </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/bimbinganskripsi</small>
    </h4>
    <p>
      Mengajukan Bimbingan Skripsi Ke Dosen Pembimbing
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
        <h5>topik_bimbingan_skripsi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_file_bimbingan_skripsi
          <small>
            <sup class="text-danger">* required</sup> file (.pdf)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>dosen_pembimbing_id_dosen_pembimbing
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id dosen dosen pembimbing dapat anda lihat pada endpoint <a class="scrollto" href="#item-21-2" target="_black">Lihat Data Dosen Pembimbing</a>
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
      "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 1",
      "dosen_pembimbing": {
        "id": "18",
        "nama_dosen_pembimbing": "Aris Wijayanti, S.T.,M.T."
      },
      "file_skripsi": {
        "nama_file": "skripsi-1412160002_07022021220826.pdf",
        "url": "fileSkripsi/skripsi-1412160002_07022021220826.pdf"
      },
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
  <section class="docs-section pt-3" id="item-25-3">
    <h3 class="section-heading">Bimbingan Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/bimbinganskripsi/{id}</small>
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
      "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 2",
      "dosen_pembimbing": {
        "id": 5,
        "nama_dosen_pembimbing": "Andy Haryoko, ST.,M.T.",
        "nidn_dosen_pembimbing": "0726047704"
      },
      "file_bimbingan_skripsi": {
        "nama_file": "skripsi-1412170001_05292021151632.pdf",
        "url": "fileSkripsi/skripsi-1412170001_05292021151632.pdf"
      },
      "status_bimbingan_skripsi": "Disetujui",
      "catatan_bimbingan_skripsi": "Cillum dolor tempor eiusmod voluptate cillum ea proident ea exercitation ut.",
      "tanggal_pengajuan_bimbingan_skripsi": "2021-05-29 15:16:32"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-25-4">
    <h3 class="section-heading">Berita Acara Bimbingan Skripsi </h3>
    <h4>
      <span class="badge badge-primary">GET</span>
      <small>mahasiswa/bimbinganskripsi/beritaacara</small>
    </h4>
    <p>
      Melihat data berita acara bimbingan skripsi, data ini dapat anda gunakan pada proses cetak berita acara bimbingan skripsi.
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
    "message": "Berita Acara Bimbingan Skripsi",
    "data": {
      "id": 12,
      "mahasiswa": {
        "id": 12,
        "nama_mahasiswa": "SHINTA WIDAYATI PUTRI",
        "npm_mahasiswa": "1412160002"
      },
      "judul_skripsi": {
        "id": 12,
        "nama_judul_skripsi": "Indonesia Raya",
        "tanggal_pengajuan_judul_skripsi": "2021-07-01 23:42:07"
      },
      "program_studi": {
        "id": 1,
        "nama_program_studi": "Teknik Informatika",
        "fakultas_program_studi": "Fakultas Teknik"
      },
      "data_bimbingan_skripsi": {
        "dosen_pembimbing_1": {
          "dosen": {
            "id": 12,
            "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
            "nidn_dosen": "0716058402"
          },
          "data_bimbingan": [
            {
              "id": 5,
              "topik_bimbingan_skripsi": "Bimbingan Skripsi BAB 1",
              "status_persetujuan_bimbingan_skripsi": "Disetujui",
              "tanggal_pengajuan_bimbingan_skripsi": "2021-07-02"
            },
            {
              "id": 6,
              "topik_bimbingan_skripsi": "Bimbingan Skripsi Bab 2",
              "status_persetujuan_bimbingan_skripsi": "Disetujui",
              "tanggal_pengajuan_bimbingan_skripsi": "2021-07-02"
            }
          ]
        },
        "dosen_pembimbing_2": {
          "dosen": {
            "id": 14,
            "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
            "nidn_dosen": "0724068905"
          },
          "data_bimbingan": [
            {
              "id": 7,
              "topik_bimbingan_skripsi": "Bimbingan Skripsi Bab 2",
              "status_persetujuan_bimbingan_skripsi": "Disetujui",
              "tanggal_pengajuan_bimbingan_skripsi": "2021-07-02"
            }
          ]
        }
      }
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

</article>