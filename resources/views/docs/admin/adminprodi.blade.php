<article class="docs-article" id="section-10">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin/Admin Prodi</h1>
    <p>
      Mengelola data Admin Prodi yang dilakukan oleh user dengan role Admin
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-10-1">
    <h3 class="section-heading">Lihat Data Admin Prodi</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/adminprodi</small>
    </h4>
    <p>
      Melihat semua data Admin Prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Admin Prodi"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"program_studi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
        },
        <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Muhammad"</span>, 
        <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>, 
        <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1212123459"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"program_studi"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Industri"</span>, 
        },
        <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Ahmad"</span>, 
        <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>, 
        <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1212123458"</span>, 
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
  <section class="docs-section pt-3" id="item-10-2">
    <h3 class="section-heading">Tambah Admin Prodi </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/adminprodi</small>
    </h4>
    <p>
      Menambahkan data Admin Prodi
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
        <h5>program_studi_id_program_studi
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nik_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nidn_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nip_admin_prodi
          <small>
            <sup class="text-danger"></sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tempat_lahir_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>tanggal_lahir_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> date
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jenis_kelamin_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> enum ('L','P')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>foto_admin_prodi
          <small>
            <sup class="text-danger"></sup> file (image)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>no_surat_tugas_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>email_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string (email)
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>no_hp_admin_prodi
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data added successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>,
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Muhammad"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1212123457"</span>, 
        <span class="hljs-attr">"role"</span>: <span class="hljs-string">"Admin Prodi"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>,
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nik_admin_prodi"</span>: <span class="hljs-string">"3523063005980009"</span>, 
      <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1212123457"</span>, 
      <span class="hljs-attr">"nip_admin_prodi"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Muhammad"</span>, 
      <span class="hljs-attr">"tempat_lahir_admin_prodi"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_admin_prodi"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"foto_admin_prodi"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-null">null</span>,
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/"</span>, 
      }, 
      <span class="hljs-attr">"no_surat_tugas_admin_prodi"</span>: <span class="hljs-string">"30/ST.FT.TI/2021"</span>, 
      <span class="hljs-attr">"email_admin_prodi"</span>: <span class="hljs-string">"admintif@mail.com"</span>, 
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
  <section class="docs-section pt-3" id="item-10-3">
    <h3 class="section-heading">Admin Prodi By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/adminprodi/{id}</small>
    </h4>
    <p>
      Melihat Data Admin Prodi Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Admin Prodi"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Muhammad"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1212123457"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nik_admin_prodi"</span>: <span class="hljs-string">"3523063005980006"</span>, 
      <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1212123457"</span>, 
      <span class="hljs-attr">"nip_admin_prodi"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Muhammad"</span>, 
      <span class="hljs-attr">"tempat_lahir_admin_prodi"</span>: <span class="hljs-string">"Tuban"</span>, 
      <span class="hljs-attr">"tanggal_lahir_admin_prodi"</span>: <span class="hljs-string">"1998-01-21"</span>, 
      <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>, 
      <span class="hljs-attr">"foto_admin_prodi"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-null">null</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/"</span>, 
      }, 
      <span class="hljs-attr">"no_surat_tugas_admin_prodi"</span>: <span class="hljs-string">"30/ST.FKIP.PE/2021"</span>, 
      <span class="hljs-attr">"email_admin_prodi"</span>: <span class="hljs-string">"adminpe@mail.com"</span>, 
      <span class="hljs-attr">"no_hp_admin_prodi"</span>: <span class="hljs-string">"085232077939"</span>, 
      <span class="hljs-attr">"tanggal_pembaruan_admin_prodi"</span>: <span class="hljs-string">"2021-06-19 23:31:16"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-10-4">
    <h3 class="section-heading">Update Admin Prodi </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/adminprodi/{id}</small>
    </h4>
    <p>
      Update Data Admin Prodi
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
        <h5>nama_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nip_admin_prodi
          <small>
            <sup class="text-danger"></sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nik_admin_prodi
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
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data Edited successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"user"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">30</span>, 
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Muhammad"</span>, 
      }, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Muhammad"</span>, 
      <span class="hljs-attr">"nip_admin_prodi"</span>: <span class="hljs-null">null</span>, 
      <span class="hljs-attr">"nik_admin_prodi"</span>: <span class="hljs-string">"3523063005980001"</span>, 
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
  <section class="docs-section pt-3" id="item-10-5">
    <h3 class="section-heading">Hapus Admin Prodi</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/adminprodi/{id}</small>
    </h4>
    <p>
      Menghapus Data Admin Prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data user & admin prodi with id 4 deleted successfully"</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Hapus -->

  <!-- Reset Password  -->
  <section class="docs-section pt-3" id="item-10-6">
    <h3 class="section-heading">Reset Password Admin Prodi </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/adminprodi/{id}/resetpassword</small>
    </h4>
    <p>
      Reset Password Admin Prodi
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
        <h5>nidn_admin_prod
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
        <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Muhammad"</span>, 
        <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1212123459"</span>, 
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