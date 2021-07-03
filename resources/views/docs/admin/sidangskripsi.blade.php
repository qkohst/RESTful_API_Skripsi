<article class="docs-article" id="section-12">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin/Sidang Skripsi</h1>
    <p>
      Melihat data Sidang Skripsi yang dilakukan oleh user dengan role Admin
    </p>
  </header>

  <!-- Lihat Sidang Skripsi  -->
  <section class="docs-section pt-0" id="item-12-1">
    <h3 class="section-heading">Lihat Data Sidang Skripsi </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/sidangskripsi</small>
    </h4>
    <p>
      Melihat semua data Sidang Skripsi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Sidang Skripsi"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"program_studi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
          <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
          <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
        }, 
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        }, 
        <span class="hljs-attr">"status_sidang_skripsi"</span>: <span class="hljs-string">"Selesai"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"program_studi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
          <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1413</span>, 
          <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Industri"</span>, 
        }, 
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1413170001"</span>, 
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Ahmad"</span>, 
        }, 
        <span class="hljs-attr">"status_sidang_skripsi"</span>: <span class="hljs-string">"Proses"</span>, 
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
  <section class="docs-section pt-3" id="item-12-2">
    <h3 class="section-heading">Sidang Skripsi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/seminarproposal/{id}</small>
    </h4>
    <p>
      Melihat Data Sidang Skripsi Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Sidang Skripsi"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"judul_skripsi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_judul_skripsi"</span>: <span class="hljs-string">"Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"</span>, 
      }, 
      <span class="hljs-attr">"dosen_pembimbing_1"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_dosen_pembimbing_1"</span>: <span class="hljs-string">"Andy Haryoko, ST.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen_pembimbing_1"</span>: <span class="hljs-string">"0726047704"</span>, 
      }, 
      <span class="hljs-attr">"dosen_pembimbing_2"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_dosen_pembimbing_2"</span>: <span class="hljs-string">"Asfan Muqtadir, ST.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen_pembimbing_2"</span>: <span class="hljs-string">"0724068905"</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji_1"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_dosen_penguji_1"</span>: <span class="hljs-string">"Aris Wijayanti, S.T.,M.T"</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji_1"</span>: <span class="hljs-string">"0716058402"</span>, 
      }, 
      <span class="hljs-attr">"dosen_penguji_2"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_dosen_penguji_2"</span>: <span class="hljs-string">"Fitroh Amaluddin, S.T.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen_penguji_2"</span>: <span class="hljs-string">"0714048502"</span>, 
      }, 
      <span class="hljs-attr">"tanggal_sidang_skripsi"</span>: <span class="hljs-string">"2021-05-27 08:00:00"</span>, 
      <span class="hljs-attr">"status_mahasiswa_sidang_skripsi"</span>: <span class="hljs-string">"Lulus"</span>, 
      <span class="hljs-attr">"nilai_akhir_sidang_skripsi"</span>: <span class="hljs-number">88</span>, 

    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

</article>