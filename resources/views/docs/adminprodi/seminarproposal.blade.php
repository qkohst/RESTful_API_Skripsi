<article class="docs-article" id="section-18">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Seminar Proposal</h1>
    <p>
      Proses pengelolaan data seminar proposal oleh admin prodi. Mulai dari proses penentuan dosen penguji dan waktu seminar, verifikasi hasil seminar proposal, dan laporan nilai hasil seminar proposal.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-3" id="item-18-1">
    <h3 class="section-heading">Lihat Data Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/seminarproposal</small>
    </h4>
    <p>
      Melihat semua data Seminar Proposal Mahasiswa sesuai program studi admin prodi
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Seminar Proposal"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>,
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>,
        },
        <span class="hljs-attr">"judul_skripsi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"nama_judul_skripsi"</span>: <span class="hljs-string">"Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"</span>,
        },
        <span class="hljs-attr">"file_seminar_proposal"</span>: {
          <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"seminar-1412170001.pdf"</span>,
          <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileSeminar/seminar-1412170001.pdf"</span>,
        },
        <span class="hljs-attr">"status_seminar_proposal"</span>: <span class="hljs-string">"Belum Mulai"</span>, 
        <span class="hljs-attr">"penguji_dan_waktu_seminar_proposal"</span>: <span class="hljs-string">"Menunggu Persetujuan Penguji"</span>, 
        <span class="hljs-attr">"tanggal_pengajuan_seminar_proposal"</span>: <span class="hljs-string">"2021-05-28 07:03:41"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">5</span>,
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170004"</span>,
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Ali Ghufron"</span>,
        },
        <span class="hljs-attr">"judul_skripsi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"nama_judul_skripsi"</span>: <span class="hljs-string">"Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"</span>,
        },
        <span class="hljs-attr">"file_seminar_proposal"</span>: {
          <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"seminar-1412170004.pdf"</span>,
          <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileSeminar/seminar-1412170004.pdf"</span>,
        },
        <span class="hljs-attr">"status_seminar_proposal"</span>: <span class="hljs-string">"Pengajuan"</span>, 
        <span class="hljs-attr">"penguji_dan_waktu_seminar_proposal"</span>: <span class="hljs-string">"Belum Ditentukan"</span>, 
        <span class="hljs-attr">"tanggal_pengajuan_seminar_proposal"</span>: <span class="hljs-string">"2021-05-28 07:03:41"</span>, 
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
  <section class="docs-section pt-3" id="item-18-2">
    <h3 class="section-heading">Seminar Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/seminarproposal/{id}</small>
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Seminar Proposal"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      }, 
      <span class="hljs-attr">"judul_skripsi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"</span>, 
      }, 
      <span class="hljs-attr">"file_seminar_proposal"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"seminar-1412170001.pdf"</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileSeminar/seminar-1412170001.pdf"</span>, 
      },
      <span class="hljs-attr">"pembimbing1_seminar_proposal"</span>: <span class="hljs-string">"Andy Haryoko, ST.,M.T."</span>, 
      <span class="hljs-attr">"pembimbing2_seminar_proposal"</span>: <span class="hljs-string">"Asfan Muqtadir, S.Kom.,M.Kom."</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-18-3">
    <h3 class="section-heading">Tentukan Penguji dan Waktu</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/seminarproposal/{id}</small>
    </h4>
    <p>
      Proses Mementukan Dosen Penguji, Waktu, dan Tempat Seminar Proposal. Setelah Dosen Penguji, Waktu dan tempat seminar proposal ditentukan, membutuhkan persetujuan dari Dosen Penguji yang di pilih.
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
        <h5>id_dosen_penguji1_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> integer
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>id_dosen_penguji2_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> integer
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>waktu_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> datetime
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id dosen dapat anda lihat pada endpoint <a class="scrollto" href="#item-15-7" target="_black">Dosen Aktif</a>. Data tersebut dapat anda gunakan untuk membuat menu pilih dosen penguji.
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data created successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">4</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"141217003"</span>, 
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Ali Ghufron"</span>, 
      }, 
      <span class="hljs-attr">"judul_skripsi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">4</span>, 
        <span class="hljs-attr">"nama_judul_skripsi"</span>: <span class="hljs-string">"Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji1_seminar_proposal"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">10</span>, 
        <span class="hljs-attr">"nama_dosen_penguji1_seminar_proposal"</span>: <span class="hljs-string">"Andy Haryoko, ST.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji1_seminar_proposal"</span>: <span class="hljs-string">"0726047704"</span>, 
        <span class="hljs-attr">"status_penguji1_seminar_proposal"</span>: <span class="hljs-string">"Antrian"</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji2_seminar_proposal"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">11</span>, 
        <span class="hljs-attr">"nama_dosen_penguji2_seminar_proposal"</span>: <span class="hljs-string">"Fitroh Amaluddin, S.T.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji2_seminar_proposal"</span>: <span class="hljs-string">"0714048502"</span>, 
        <span class="hljs-attr">"status_penguji2_seminar_proposal"</span>: <span class="hljs-string">"Antrian"</span>, 
      }, 
      <span class="hljs-attr">"waktu_seminar_proposal"</span>: <span class="hljs-string">"2021-06-28 09:00:00"</span>, 
      <span class="hljs-attr">"tempat_seminar_proposal"</span>: <span class="hljs-string">"Lab Jarkom"</span>, 
      <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"1 detik yang lalu"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-18-4">
    <h3 class="section-heading">Status Persetujuan Penguji</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/seminarproposal/{id}/penguji</small>
    </h4>
    <p>
      Memlihat Status Persetujuan Dosen Penguji
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Submission status"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">5</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170004"</span>, 
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Ali Ghufron"</span>, 
      }, 
      <span class="hljs-attr">"judul_skripsi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_judul_skripsi"</span>: <span class="hljs-string">"Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas"</span>, 
      }, 
      <span class="hljs-attr">"dosen_pembimbing1"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">10</span>, 
        <span class="hljs-attr">"nidn_dosen_pembimbing1"</span>: <span class="hljs-string">"0724068905"</span>, 
        <span class="hljs-attr">"nama_dosen_pembimbing1"</span>: <span class="hljs-string">"Asfan Muqtadir, S.Kom.,M.Kom"</span>, 
      }, 
      <span class="hljs-attr">"dosen_pembimbing2"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">11</span>, 
        <span class="hljs-attr">"nidn_dosen_pembimbing2"</span>: <span class="hljs-string">"0716058402"</span>, 
        <span class="hljs-attr">"nama_dosen_pembimbing2"</span>: <span class="hljs-string">"Aris Wijayanti, S.T.,M.T."</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji1"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji1"</span>: <span class="hljs-string">"0724068909"</span>, 
        <span class="hljs-attr">"nama_dosen_penguji1"</span>: <span class="hljs-string">"Andik Adi Suryanto, S.Kom.,M.Kom"</span>, 
        <span class="hljs-attr">"persetujuan_dosen_penguji1"</span>: <span class="hljs-string">"Antrian"</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji2"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">16</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji2"</span>: <span class="hljs-string">"0726047704"</span>, 
        <span class="hljs-attr">"nama_dosen_penguji2"</span>: <span class="hljs-string">"Andy Haryoko, ST.,M.T."</span>, 
        <span class="hljs-attr">"persetujuan_dosen_penguji2"</span>: <span class="hljs-string">"Antrian"</span>, 
      }, 
      <span class="hljs-attr">"waktu_seminar_proposal"</span>: <span class="hljs-string">"2021-06-30 08:30:00"</span>, 
      <span class="hljs-attr">"tempat_seminar_proposal"</span>: <span class="hljs-string">"Lab Jarkom"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Tambah -->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-18-5">
    <h3 class="section-heading">Hasil Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/seminarproposal/{id}/hasil</small>
    </h4>
    <p>
      Melihat hasil verifikasi pelaksanaan seminar proposal oleh dosen dosen penguji dan dosen pembimbing.
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Hasil Seminar"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_dosen_seminar_proposal"</span>: <span class="hljs-string">"Andy Haryoko, ST.,M.T."</span>, 
        <span class="hljs-attr">"status_dosen_seminar_proposal"</span>: <span class="hljs-string">"Pembimbing 1"</span>, 
        <span class="hljs-attr">"status_verifikasi_dosen_seminar_proposal"</span>: <span class="hljs-string">"Lulus Seminar"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
        <span class="hljs-attr">"nama_dosen_seminar_proposal"</span>: <span class="hljs-string">"Aris Wijayanti, S.T.,M.T."</span>, 
        <span class="hljs-attr">"status_dosen_seminar_proposal"</span>: <span class="hljs-string">"Penguji 1"</span>, 
        <span class="hljs-attr">"status_verifikasi_dosen_seminar_proposal"</span>: <span class="hljs-string">"Revisi"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3</span>, 
        <span class="hljs-attr">"nama_dosen_seminar_proposal"</span>: <span class="hljs-string">"Asfan Muqtadir, S.Kom.,M.Kom"</span>, 
        <span class="hljs-attr">"status_dosen_seminar_proposal"</span>: <span class="hljs-string">"Pembimbing 2"</span>, 
        <span class="hljs-attr">"status_verifikasi_dosen_seminar_proposal"</span>: <span class="hljs-string">"Lulus Seminar"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">4</span>, 
        <span class="hljs-attr">"nama_dosen_seminar_proposal"</span>: <span class="hljs-string">"Fitroh Amaluddin, S.T.,M.T."</span>, 
        <span class="hljs-attr">"status_dosen_seminar_proposal"</span>: <span class="hljs-string">"Penguji 2"</span>, 
        <span class="hljs-attr">"status_verifikasi_dosen_seminar_proposal"</span>: <span class="hljs-string">"Lulus Seminar"</span>, 
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

    <!-- Tambah Fakultas  -->
    <section class="docs-section pt-3" id="item-18-6">
      <h3 class="section-heading">Verifikasi Seminar Proposal </h3>
      <h4>
        <span class="badge badge-primary">POST</span>
        <small>adminprodi/seminarproposal/{id}/verifikasi</small>
      </h4>
      <p>
        Proses verifikasi seminar proposal selesai setelah status verifikasi dari dosen pembimbing dan dosen penguji dinyatakan lulus seminar.
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
      </div>

      <!-- Response -->
      <h5 class="pt-2">Responses:</h5>
      <div class="docs-code-block pt-0 pb-0">
        <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Verification of the seminar proposal with id 2 was successful"</span>,
  }
                  </code>
                </pre>
      </div>
      <!-- Akhir Response -->

    </section>
    <!--//section Tambah -->

  </section>
  <!--//section Tambah -->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-18-7">
    <h3 class="section-heading">Nilai Seminar Proposal </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/seminarproposal/{id}/daftarnilai</small>
    </h4>
    <p>
      Setelah verifikasi oleh dosen pembimbing dan dosen penguji dinyatakan lulus seminar dan sudah dilakukan input nilai, admin prodi dapat melihat laporan nilai seminar proposal yang telah dilaksanakan.
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
    "message": "List of Data Nilai Seminar Proposal",
    "data": {
      "id": 2,
      "mahasiswa": {
        "id": 2,
        "nama_mahasiswa": "Kukoh Santoso",
        "npm_mahasiswa": "1412170001"
      },
      "program_studi": {
        "id": 1,
        "fakultas_program_studi": "Fakultas Teknik",
        "nama_program_studi": "Teknik Informatika"
      },
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "waktu_seminar_proposal": "2021-05-27 08:00:00",
      "tempat_seminar_proposal": "Lab Data Mining",
      "nilai_pembimbing1": {
        "dosen": {
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704"
        },
        "nilai_a": {
          "deskripsi_nilai_a_hasil_seminar_proposal": "Nilai Pembimbingan Proposal",
          "nilai_a1_hasil_seminar_proposal": 75,
          "nilai_a2_hasil_seminar_proposal": 80,
          "nilai_a3_hasil_seminar_proposal": 85,
          "jumlah_nilai_a_hasil_seminar_proposal": 240,
          "rata2_nilai_a_hasil_seminar_proposal": 80
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_seminar_proposal": "Nilai Naskah Proposal Skripsi",
          "nilai_b1_hasil_seminar_proposal": 87,
          "nilai_b2_hasil_seminar_proposal": 84,
          "nilai_b3_hasil_seminar_proposal": 85,
          "nilai_b4_hasil_seminar_proposal": 86,
          "nilai_b5_hasil_seminar_proposal": 84,
          "nilai_b6_hasil_seminar_proposal": 78,
          "nilai_b7_hasil_seminar_proposal": 82,
          "jumlah_nilai_b_hasil_seminar_proposal": 586,
          "rata2_nilai_b_hasil_seminar_proposal": 84
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_seminar_proposal": "Nilai Pelaksanaan Seminar Proposal",
          "nilai_c1_hasil_seminar_proposal": 80,
          "nilai_c2_hasil_seminar_proposal": 84,
          "nilai_c3_hasil_seminar_proposal": 89,
          "jumlah_nilai_c_hasil_seminar_proposal": 253,
          "rata2_nilai_c_hasil_seminar_proposal": 85
        }
      },
      "nilai_pembimbing2": {
        "dosen": {
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905"
        },
        "nilai_a": {
          "deskripsi_nilai_a_hasil_seminar_proposal": "Nilai Pembimbingan Proposal",
          "nilai_a1_hasil_seminar_proposal": 89,
          "nilai_a2_hasil_seminar_proposal": 87,
          "nilai_a3_hasil_seminar_proposal": 86,
          "jumlah_nilai_a_hasil_seminar_proposal": 262,
          "rata2_nilai_a_hasil_seminar_proposal": 87
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_seminar_proposal": "Nilai Naskah Proposal Skripsi",
          "nilai_b1_hasil_seminar_proposal": 87,
          "nilai_b2_hasil_seminar_proposal": 84,
          "nilai_b3_hasil_seminar_proposal": 85,
          "nilai_b4_hasil_seminar_proposal": 86,
          "nilai_b5_hasil_seminar_proposal": 84,
          "nilai_b6_hasil_seminar_proposal": 78,
          "nilai_b7_hasil_seminar_proposal": 82,
          "jumlah_nilai_b_hasil_seminar_proposal": 586,
          "rata2_nilai_b_hasil_seminar_proposal": 84
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_seminar_proposal": "Nilai Pelaksanaan Seminar Proposal",
          "nilai_c1_hasil_seminar_proposal": 80,
          "nilai_c2_hasil_seminar_proposal": 84,
          "nilai_c3_hasil_seminar_proposal": 89,
          "jumlah_nilai_c_hasil_seminar_proposal": 253,
          "rata2_nilai_c_hasil_seminar_proposal": 85
        }
      },
      "nilai_penguji1": {
        "dosen": {
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402"
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_seminar_proposal": "Nilai Naskah Proposal Skripsi",
          "nilai_b1_hasil_seminar_proposal": 87,
          "nilai_b2_hasil_seminar_proposal": 84,
          "nilai_b3_hasil_seminar_proposal": 85,
          "nilai_b4_hasil_seminar_proposal": 86,
          "nilai_b5_hasil_seminar_proposal": 84,
          "nilai_b6_hasil_seminar_proposal": 78,
          "nilai_b7_hasil_seminar_proposal": 82,
          "jumlah_nilai_b_hasil_seminar_proposal": 586,
          "rata2_nilai_b_hasil_seminar_proposal": 84
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_seminar_proposal": "Nilai Pelaksanaan Seminar Proposal",
          "nilai_c1_hasil_seminar_proposal": 80,
          "nilai_c2_hasil_seminar_proposal": 84,
          "nilai_c3_hasil_seminar_proposal": 89,
          "jumlah_nilai_c_hasil_seminar_proposal": 253,
          "rata2_nilai_c_hasil_seminar_proposal": 85
        }
      },
      "nilai_penguji2": {
        "dosen": {
          "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
          "nidn_dosen": "0714048502"
        },
        "nilai_b": {
          "deskripsi_nilai_b_hasil_seminar_proposal": "Nilai Naskah Proposal Skripsi",
          "nilai_b1_hasil_seminar_proposal": 87,
          "nilai_b2_hasil_seminar_proposal": 84,
          "nilai_b3_hasil_seminar_proposal": 85,
          "nilai_b4_hasil_seminar_proposal": 86,
          "nilai_b5_hasil_seminar_proposal": 84,
          "nilai_b6_hasil_seminar_proposal": 78,
          "nilai_b7_hasil_seminar_proposal": 82,
          "jumlah_nilai_b_hasil_seminar_proposal": 586,
          "rata2_nilai_b_hasil_seminar_proposal": 84
        },
        "nilai_c": {
          "deskripsi_nilai_c_hasil_seminar_proposal": "Nilai Pelaksanaan Seminar Proposal",
          "nilai_c1_hasil_seminar_proposal": 80,
          "nilai_c2_hasil_seminar_proposal": 84,
          "nilai_c3_hasil_seminar_proposal": 89,
          "jumlah_nilai_c_hasil_seminar_proposal": 253,
          "rata2_nilai_c_hasil_seminar_proposal": 85
        }
      },
      "rekap_nilai": {
        "rata2_nilai_a_hasil_seminar_proposal": 84,
        "rata2_nilai_b_hasil_seminar_proposal": 84,
        "rata2_nilai_c_hasil_seminar_proposal": 85,
        "jumlah_rata2_nilai_hasil_seminar_proposal": 252,
        "nilai_akhir_hasil_seminar_proposal": 84
      }
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Tambah -->

</article>