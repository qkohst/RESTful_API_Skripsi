<article class="docs-article" id="section-23">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Bimbingan Proposal</h1>
    <p>
      Setelah tahap Persyaratan Skripsi selesai, mahasiswa dapat melanjutkan pada proses bimbingan proposal skripsi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-23-1">
    <h3 class="section-heading">Lihat Data Bimbingan Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/bimbinganproposal</small>
    </h4>
    <p>
      Melihat semua data bimbingan proposal skripsi mahasiswa.
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
        "id": 9,
        "dosen_pembimbing": {
          "id": 5,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "jabatan_dosen_pembimbing": "Pembimbing 1"
        },
        "file_bimbingan_proposal": {
          "nama_file": "proposal-1412170001_05242021175703.pdf",
          "url": "fileProposal/proposal-1412170001_05242021175703.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 3",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "Consequat eiusmod reprehenderit quis consectetur mollit laboris nulla aute. Proident nostrud elit tempor incididunt laborum commodo officia magna. Est ullamco irure aliquip enim aliqua esse voluptate do ut qui. Ullamco ullamco consectetur velit elit dolore. Quis non duis ex voluptate enim aliquip dolore excepteur ex fugiat pariatur esse. Incididunt eu ipsum officia ipsum commodo culpa officia ex proident officia officia esse ex enim. Magna officia dolor commodo Lorem irure consequat ea culpa dolor excepteur aliqua ad.",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 17:57:03"
      },
      {
        "id": 8,
        "dosen_pembimbing": {
          "id": 9,
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905",
          "jabatan_dosen_pembimbing": "Pembimbing 2"
        },
        "file_bimbingan_proposal": {
          "nama_file": "proposal-1412170001_05242021175010.pdf",
          "url": "fileProposal/proposal-1412170001_05242021175010.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 2",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "Commodo et occaecat et mollit.",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 17:50:10"
      },
      {
        "id": 2,
        "dosen_pembimbing": {
          "id": 5,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "jabatan_dosen_pembimbing": "Pembimbing 1"
        },
        "file_bimbingan_proposal": {
          "nama_file": "proposal-1412170001_05242021161816.pdf",
          "url": "fileProposal/proposal-1412170001_05242021161816.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 2",
        "status_persetujuan_bimbingan_proposal": "Revisi",
        "catatan_bimbingan_proposal": "Consequat Lorem sunt fugiat velit adipisicing cillum consequat esse in.",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 16:18:16"
      },
      {
        "id": 1,
        "dosen_pembimbing": {
          "id": 5,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "jabatan_dosen_pembimbing": "Pembimbing 1"
        },
        "file_bimbingan_proposal": {
          "nama_file": "proposal-1412170001_05242021161610.pdf",
          "url": "fileProposal/proposal-1412170001_05242021161610.pdf"
        },
        "topik_bimbingan_proposal": "Bimbingan BAB 1",
        "status_persetujuan_bimbingan_proposal": "Disetujui",
        "catatan_bimbingan_proposal": "Ullamco incididunt laborum veniam do nisi proident aute exercitation sunt proident ea.",
        "tanggal_pengajuan_bimbingan_proposal": "2021-05-24 16:16:10"
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
  <section class="docs-section pt-3" id="item-23-2">
    <h3 class="section-heading">Pengajuan Bimbingan Proposal </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/bimbinganproposal</small>
    </h4>
    <p>
      Mengajukan Bimbingan Proposal Ke Dosen Pembimbing
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
        <h5>topik_bimbingan_proposal
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_file_bimbingan_proposal
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
      "id": 12,
      "topik_bimbingan_proposal": "Bimbingan BAB 1",
      "dosen_pembimbing": {
        "id": "18",
        "nama_dosen_pembimbing": "Aris Wijayanti, S.T.,M.T."
      },
      "file_proposal": {
        "nama_file": "proposal-1412160002_07022021125131.pdf",
        "url": "fileProposal/proposal-1412160002_07022021125131.pdf"
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
  <section class="docs-section pt-3" id="item-23-3">
    <h3 class="section-heading">Bimbingan Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/bimbinganproposal/{id}</small>
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
      "id": 11,
      "topik_bimbingan_proposal": "Bimbingan BAB 1",
      "dosen_pembimbing": {
        "id": 11,
        "nama_dosen_pembimbing": "Asfan Muqtadir, S.Kom.,M.Kom",
        "nidn_dosen_pembimbing": "0724068905"
      },
      "file_bimbingan_proposal": {
        "nama_file": "proposal-1412170004_05282021070226.pdf",
        "url": "fileProposal/proposal-1412170004_05282021070226.pdf"
      },
      "status_bimbingan_proposal": "Disetujui",
      "catatan_bimbingan_proposal": "Occaecat aute ut quis voluptate.",
      "tanggal_pengajuan_bimbingan_proposal": "2021-05-28 07:02:26"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-23-4">
    <h3 class="section-heading">Berita Acara Bimbingan Proposal </h3>
    <h4>
      <span class="badge badge-primary">GET</span>
      <small>mahasiswa/bimbinganproposal/beritaacara</small>
    </h4>
    <p>
      Melihat data berita acara bimbingan proposal, data ini dapat anda gunakan pada proses cetak berita acara bimbingan proposal.
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
    "message": "Berita Acara Bimbingan Proposal",
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
      "data_bimbingan_proposal": {
        "dosen_pembimbing_1": {
          "dosen": {
            "id": 12,
            "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
            "nidn_dosen": "0716058402"
          },
          "data_bimbingan": [
            {
              "id": 12,
              "topik_bimbingan_proposal": "Bimbingan BAB 1",
              "status_persetujuan_bimbingan_proposal": "Revisi",
              "tanggal_pengajuan_bimbingan_proposal": "2021-07-02"
            },
            {
              "id": 13,
              "topik_bimbingan_proposal": "Bimbingan Bab 2",
              "status_persetujuan_bimbingan_proposal": "Disetujui",
              "tanggal_pengajuan_bimbingan_proposal": "2021-07-02"
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
              "id": 14,
              "topik_bimbingan_proposal": "Bimbingan Bab 3",
              "status_persetujuan_bimbingan_proposal": "Disetujui",
              "tanggal_pengajuan_bimbingan_proposal": "2021-07-02"
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