<article class="docs-article" id="section-15">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Dosen</h1>
    <p>
      Mengelola data Dosen yang dilakukan oleh user dengan role Admin Prodi
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-15-1">
    <h3 class="section-heading">Lihat Data Dosen</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/dosen</small>
    </h4>
    <p>
      Melihat semua data Dosen sesuai program studi admin prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List Dosen of Program Studi Teknik Informatika"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Andik Adi Suryanto, S.Kom.,M.Kom"</span>, 
        <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0724068909"</span>, 
        <span class="hljs-attr">"nip_dosen"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"jenis_kelamin_dosen"</span>: <span class="hljs-string">"L"</span>, 
        <span class="hljs-attr">"tanggal_lahir_dosen"</span>: <span class="hljs-string">"1998-05-30"</span>, 
        <span class="hljs-attr">"status_dosen"</span>: <span class="hljs-string">"Aktif"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Siti Aminah, ST.,M.T."</span>, 
        <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0724068907"</span>, 
        <span class="hljs-attr">"nip_dosen"</span>: <span class="hljs-string">"352305260477000109"</span>, 
        <span class="hljs-attr">"jenis_kelamin_dosen"</span>: <span class="hljs-string">"P"</span>, 
        <span class="hljs-attr">"tanggal_lahir_dosen"</span>: <span class="hljs-string">"1998-05-30"</span>, 
        <span class="hljs-attr">"status_dosen"</span>: <span class="hljs-string">"Non Aktif"</span>, 
      }
     
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Login-->

  <!-- Tambah Fakultas  -->
  <section class="docs-section pt-3" id="item-15-2">
    <h3 class="section-heading">Tambah Dosen </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/dosen</small>
    </h4>
    <p>
      Menambahkan data Dosen
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
        <h5>nama_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nik_dosen
          <small>
            <sup class="text-danger"></sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nidn_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nip_dosen
          <small>
            <sup class="text-danger"></sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_lahir_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tanggal_lahir_dosen
          <small>
            <sup class="text-danger">* required</sup> date
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jenis_kelamin_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('L','P')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>agama_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('Islam','Protestan','Katolik','Hindu','Budha','Khonghucu','Kepercayaan')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>gelar_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>pendidikan_terakhir_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('S1','S2',S3)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jabatan_fungsional_id_jabatan_fungsional
          <small>
            <sup class="text-danger"></sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jabatan_struktural_id_jabatan_struktural
          <small>
            <sup class="text-danger"></sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id jabatan struktural dapat anda lihat pada endpoint <a class="scrollto" href="#item-16-1" target="_black">Lihat Data Jabatan Struktural</a>
    </div>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id jabatan fungsional dapat anda lihat pada endpoint <a class="scrollto" href="#item-16-2" target="_black">Lihat Data Jabatan Fungsional</a>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data added successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">14</span>,
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Anggia Kalista"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"0702108409"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>,
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Anggia Kalista"</span>, 
      <span class="hljs-attr">"nik_dosen"</span>: <span class="hljs-string">"3523164210840001"</span>, 
      <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0702108409"</span>, 
      <span class="hljs-attr">"nip_dosen"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"tempat_lahir_dosen"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_dosen"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_dosen"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"agama_dosen"</span>: <span class="hljs-string">"Islam"</span>, 
      <span class="hljs-attr">"gelar_dosen"</span>: <span class="hljs-string">"S.T.,M.T."</span>, 
      <span class="hljs-attr">"pendidikan_terakhir_dosen"</span>: <span class="hljs-string">"S2"</span>, 
      <span class="hljs-attr">"jabatan_fungsional"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Dosen"</span>, 
      }, 
      <span class="hljs-attr">"jabatan_struktural"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"nama_jabatan_struktural"</span>: <span class="hljs-null">null</span>, 
      }, 
      <span class="hljs-attr">"status_dosen"</span>: <span class="hljs-string">"Aktif"</span>, 
      <span class="hljs-attr">"created_at"</span>: <span class="hljs-string">"1 detik yang lalu"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Tambah -->

  <!-- Fakultas By ID -->
  <section class="docs-section pt-3" id="item-15-3">
    <h3 class="section-heading">Dosen By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/dosen/{id}</small>
    </h4>
    <p>
      Melihat Data Dosen Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Dosen"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Andik Adi Suryanto"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"0724068909"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Andik Adi Suryanto"</span>, 
      <span class="hljs-attr">"nik_dosen"</span>: <span class="hljs-string">"3524141410850009"</span>, 
      <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0724068909"</span>, 
      <span class="hljs-attr">"nip_dosen"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"tempat_lahir_dosen"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_dosen"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_dosen"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"status_perkawinan_dosen"</span>: <span class="hljs-string">"Kawin"</span>, 
      <span class="hljs-attr">"agama_dosen"</span>: <span class="hljs-string">"Islam"</span>, 
      <span class="hljs-attr">"nama_ibu_dosen"</span>: <span class="hljs-string">"Darmini"</span>, 
      <span class="hljs-attr">"gelar_dosen"</span>: <span class="hljs-string">"S.Kom.,M.Kom."</span>, 
      <span class="hljs-attr">"alamat_dosen"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"provinsi_dosen"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">35</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Jawa Timur"</span>, 
      }, 
      <span class="hljs-attr">"kabupaten_dosen"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3523</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Tuban"</span>, 
      }, 
      <span class="hljs-attr">"kecamatan_dosen"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3514170</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Tambakboyo"</span>, 
      }, 
      <span class="hljs-attr">"desa_dosen"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3514170017</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Dikir"</span>, 
      }, 
      <span class="hljs-attr">"email_dosen"</span>: <span class="hljs-string">"email@mail.com"</span>, 
      <span class="hljs-attr">"no_hp_dosen"</span>: <span class="hljs-string">"085232077939"</span>, 
      <span class="hljs-attr">"jabatan_fungsional"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-null">null</span>, 
      }, 
      <span class="hljs-attr">"jabatan_struktural"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_jabatan_struktural"</span>: <span class="hljs-string">"Dosen"</span>, 
      }, 
      <span class="hljs-attr">"foto_dosen"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/"</span>, 
      }, 
      <span class="hljs-attr">"status_dosen"</span>: <span class="hljs-string">"Aktif"</span>, 
      <span class="hljs-attr">"tanggal_pembaruan_dosen"</span>: <span class="hljs-string">"2021-06-19 23:31:16"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-15-4">
    <h3 class="section-heading">Update Dosen </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/dosen/{id}</small>
    </h4>
    <p>
      Update Data Dosen
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
        <h5>nama_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_lahir_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tanggal_lahir_dosen
          <small>
            <sup class="text-danger">* required</sup> date
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nip_dosen
          <small>
            <sup class="text-danger"></sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nik_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jabatan_fungsional_id_jabatan_fungsional
          <small>
            <sup class="text-danger"></sup> integer
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jabatan_struktural_id_jabatan_struktural
          <small>
            <sup class="text-danger"></sup> integer
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>gelar_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>pendidikan_terakhir_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>status_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('Aktif','Non Aktif')
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id jabatan struktural dapat anda lihat pada endpoint <a class="scrollto" href="#item-16-1" target="_black">Lihat Data Jabatan Struktural</a>
    </div>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id jabatan fungsional dapat anda lihat pada endpoint <a class="scrollto" href="#item-16-2" target="_black">Lihat Data Jabatan Fungsional</a>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data Edited successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">30</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Siti Aminah"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Siti Aminah"</span>, 
      <span class="hljs-attr">"tempat_lahir_dosen"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_dosen"</span>: <span class="hljs-string">"1997-05-30"</span>, 
      <span class="hljs-attr">"nip_dosen"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"nik_dosen"</span>: <span class="hljs-string">"3524141410850001"</span>, 
      <span class="hljs-attr">"jabatan_fungsional"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Dosen Ahli"</span>, 
      }, 
      <span class="hljs-attr">"jabatan_struktural"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_jabatan_struktural"</span>: <span class="hljs-string">"Dosen"</span>, 
      }, 
      <span class="hljs-attr">"gelar_dosen"</span>: <span class="hljs-string">"S.T.,M.T."</span>, 
      <span class="hljs-attr">"pendidikan_terakhir_dosen"</span>: <span class="hljs-string">"S2"</span>, 
      <span class="hljs-attr">"status_dosen"</span>: <span class="hljs-string">"Non Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-15-5">
    <h3 class="section-heading">Hapus Dosen</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/dosen/{id}</small>
    </h4>
    <p>
      Menghapus Data Dosen
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
            <sup class="text-danger">* required</sup> string <b>value : DELETE</b>
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data user & dosen with id 16 deleted successfully"</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Hapus -->

  <!-- Reset Password  -->
  <section class="docs-section pt-3" id="item-15-6">
    <h3 class="section-heading">Reset Password Dosen </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/dosen/{id}/resetpassword</small>
    </h4>
    <p>
      Reset Password Dosen
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
        <h5>nidn_dosen
          <small>
            <sup class="text-danger">* required</sup> integer <i>$int32</i>
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Password reset successful"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">30</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Aris Wijayanti"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"0716058402"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-3" id="item-15-7">
    <h3 class="section-heading">Dosen Aktif</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/dosen/aktif</small>
    </h4>
    <p>
      Melihat semua data Dosen sesuai program studi admin prodi dengan <code>status</code> Aktif. Data ini dapat digunakan pada proses penentukan dosen penguji pada proses <a class="scrollto" href="#item-18-3" target="_black">Seminar Proposal</a>.
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data dosen at Teknik Informatika with an active status"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0724068909"</span>, 
        <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Andik Adi Suryanto, S.Kom.,M.Kom"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"nidn_dosen"</span>: <span class="hljs-string">"0724068907"</span>, 
        <span class="hljs-attr">"nama_dosen"</span>: <span class="hljs-string">"Siti Aminah, ST.,M.T."</span>, 
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Login-->
</article>