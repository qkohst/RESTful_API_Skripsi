<article class="docs-article" id="section-13">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Profile</h1>
    <p>
      Mengelola data profile admin prodi oleh user
    </p>
  </header>

  <!-- Lihat Profile -->
  <section class="docs-section pt-0" id="item-13-1">
    <h3 class="section-heading">Lihat Profile </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/profile</small>
    </h4>
    <p>
      Melihat data profile admin prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Profile Admin Prodi"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nama_admin_prodi"</span>: <span class="hljs-string">"Muhammad"</span>,    
      <span class="hljs-attr">"nik_admin_prodi"</span>: <span class="hljs-string">"3523063003820001"</span>,    
      <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1490000001"</span>,    
      <span class="hljs-attr">"nip_admin_prodi"</span>: <span class="hljs-null">null</span>,    
      <span class="hljs-attr">"tempat_lahir_admin_prodi"</span>: <span class="hljs-string">"Tuban"</span>,    
      <span class="hljs-attr">"tanggal_lahir_admin_prodi"</span>: <span class="hljs-string">"1982-03-30"</span>,    
      <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>,    
      <span class="hljs-attr">"foto_admin_prodi"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"img-1212123459.png"</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/img-1212123459.png"</span>, 
      }, 
      <span class="hljs-attr">"no_surat_tugas_admin_prodi"</span>: <span class="hljs-string">"30/ST.FT.TIF/2021""</span>,    
      <span class="hljs-attr">"email_admin_prodi"</span>: <span class="hljs-string">"adminti2@mail.com"</span>,    
      <span class="hljs-attr">"no_hp_admin_prodi"</span>: <span class="hljs-string">"0852320779324"</span>,    
      <span class="hljs-attr">"tanggal_pembaruan_admin_prodi"</span>: <span class="hljs-string">"2021-06-21 01:05:54"</span>,    
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

  <!-- Update Profile -->
  <section class="docs-section pt-3" id="item-13-2">
    <h3 class="section-heading">Update Profile </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/profile</small>
    </h4>
    <p>
      Merubah data profile admin prodi
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
            <sup class="text-danger"></sup> enum ('L','P')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>email_admin_prodi
          <small>
            <sup class="text-danger">* required</sup> string <i>(email)</i>
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
      <div class="pt-3">
        <h5>foto_admin_prodi
          <small>
            <sup class="text-danger"></sup> file <i>(image)</i>
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Profile updated successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"program_studi"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_program_studi"</span>: <span class="hljs-number">1412</span>, 
        <span class="hljs-attr">"nama_program_studi"</span>: <span class="hljs-string">"Teknik Informatika"</span>, 
      }, 
      <span class="hljs-attr">"nik_admin_prodi"</span>: <span class="hljs-string">"3523063003820001"</span>,    
      <span class="hljs-attr">"nidn_admin_prodi"</span>: <span class="hljs-string">"1490000001"</span>,    
      <span class="hljs-attr">"tempat_lahir_admin_prodi"</span>: <span class="hljs-string">"Tuban"</span>,    
      <span class="hljs-attr">"tanggal_lahir_admin_prodi"</span>: <span class="hljs-string">"1982-03-30"</span>,    
      <span class="hljs-attr">"jenis_kelamin_admin_prodi"</span>: <span class="hljs-string">"L"</span>,    
      <span class="hljs-attr">"foto_admin_prodi"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"img-1490000001.png"</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileFotoProfile/img-1490000001.png"</span>, 
      }, 
      <span class="hljs-attr">"no_surat_tugas_admin_prodi"</span>: <span class="hljs-string">"30/ST.FT.TIF/2021"</span>,    
      <span class="hljs-attr">"email_admin_prodi"</span>: <span class="hljs-string">"admin2@mail.com"</span>,    
      <span class="hljs-attr">"no_hp_admin_prodi"</span>: <span class="hljs-string">"0852320779324"</span>,    
      <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"1 Detik yang lalu"</span>,    
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Update Profile-->

</article>