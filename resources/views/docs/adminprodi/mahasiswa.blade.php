<article class="docs-article" id="section-14">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Mahasiswa</h1>
    <p>
      Mengelola data Mahasiswa yang dilakukan oleh user dengan role Admin Prodi
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-14-1">
    <h3 class="section-heading">Lihat Data Mahasiswa</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/mahasiswa</small>
    </h4>
    <p>
      Melihat semua data Mahasiswa sesuai program studi admin prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List Mahasiswa of Program Studi Teknik Informatika"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
        <span class="hljs-attr">"jenis_kelamin_mahasiswa"</span>: <span class="hljs-string">"L"</span>, 
        <span class="hljs-attr">"tanggal_lahir_mahasiswa"</span>: <span class="hljs-string">"1998-05-30"</span>, 
        <span class="hljs-attr">"semester_mahasiswa"</span>: <span class="hljs-number">8</span>, 
        <span class="hljs-attr">"status_mahasiswa"</span>: <span class="hljs-string">"Lulus"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Ali"</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170002"</span>, 
        <span class="hljs-attr">"jenis_kelamin_mahasiswa"</span>: <span class="hljs-string">"L"</span>, 
        <span class="hljs-attr">"tanggal_lahir_mahasiswa"</span>: <span class="hljs-string">"1996-05-30"</span>, 
        <span class="hljs-attr">"semester_mahasiswa"</span>: <span class="hljs-number">10</span>, 
        <span class="hljs-attr">"status_mahasiswa"</span>: <span class="hljs-string">"Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-14-2">
    <h3 class="section-heading">Tambah Mahasiswa </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/mahasiswa</small>
    </h4>
    <p>
      Menambahkan data Mahasiswa
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
        <h5>nama_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>npm_mahasiswa
          <small>
            <sup class="text-danger"></sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>semester_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum <i>between</i> ('1','14')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_lahir_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tanggal_lahir_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> date
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jenis_kelamin_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum ('L','P')
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data added successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>,
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1412170001"</span>, 
        <span class="hljs-attr">"role"</span>: <span class="hljs-string">"Mahasiswa"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>,
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
      <span class="hljs-attr">"semester_mahasiswa"</span>: <span class="hljs-string">"8"</span>, 
      <span class="hljs-attr">"tempat_lahir_mahasiswa"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_mahasiswa"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_mahasiswa"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"status_mahasiswa"</span>: <span class="hljs-string">"Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-14-3">
    <h3 class="section-heading">Mahasiswa By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/mahasiswa/{id}</small>
    </h4>
    <p>
      Melihat Data Mahasiswa Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Mahasiswa"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1412170001"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>, 
      <span class="hljs-attr">"semester_mahasiswa"</span>: <span class="hljs-number">8</span>, 
      <span class="hljs-attr">"tempat_lahir_mahasiswa"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_mahasiswa"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_mahasiswa"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"status_perkawinan_mahasiswa"</span>: <span class="hljs-string">"Belum Kawin"</span>, 
      <span class="hljs-attr">"agama_mahasiswa"</span>: <span class="hljs-string">"Islam"</span>, 
      <span class="hljs-attr">"nama_ibu_mahasiswa"</span>: <span class="hljs-string">"Darmini"</span>, 
      <span class="hljs-attr">"alamat_mahasiswa"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"provinsi_mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">35</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Jawa Timur"</span>, 
      }, 
      <span class="hljs-attr">"kabupaten_mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3523</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Tuban"</span>, 
      }, 
      <span class="hljs-attr">"kecamatan_mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3514170</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Tambakboyo"</span>, 
      }, 
      <span class="hljs-attr">"desa_mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">3514170017</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Dikir"</span>, 
      }, 
      <span class="hljs-attr">"foto_mahasiswa"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/"</span>, 
      }, 
      <span class="hljs-attr">"email_mahasiswa"</span>: <span class="hljs-string">"kukohsan@mail.com"</span>, 
      <span class="hljs-attr">"no_hp_mahasiswa"</span>: <span class="hljs-string">"085232077939"</span>, 
      <span class="hljs-attr">"status_mahasiswa"</span>: <span class="hljs-string">"Aktif"</span>, 
      <span class="hljs-attr">"tanggal_pembaruan_mahasiswa"</span>: <span class="hljs-string">"2021-06-19 23:31:16"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-14-4">
    <h3 class="section-heading">Update Mahasiswa </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/mahasiswa/{id}</small>
    </h4>
    <p>
      Update Data Mahasiswa
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
        <h5>nama_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_lahir_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tanggal_lahir_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> date
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>status_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum ('Aktif','Non Aktif','Drop Out')
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data Edited successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">30</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      <span class="hljs-attr">"tempat_lahir_mahasiswa"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_mahasiswa"</span>: <span class="hljs-string">"1997-05-30"</span>, 
      <span class="hljs-attr">"status_mahasiswa"</span>: <span class="hljs-string">"Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-14-5">
    <h3 class="section-heading">Hapus Mahasiswa</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/mahasiswa/{id}</small>
    </h4>
    <p>
      Menghapus Data Mahasiswa
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data user & mahasiswa with id 9 deleted successfully"</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Hapus -->

  <!-- Reset Password  -->
  <section class="docs-section pt-3" id="item-14-6">
    <h3 class="section-heading">Reset Password Mahasiswa </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/mahasiswa/{id}/resetpassword</small>
    </h4>
    <p>
      Reset Password Mahasiswa
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
        <h5>npm_mahasiswa
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
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1412170001"</span>, 
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
</article>