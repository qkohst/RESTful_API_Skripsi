<article class="docs-article" id="section-17">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Persetujuan KRS</h1>
    <p>
      KRS yang telah diupload oleh Mahasiswa pada proses Persyaratan Skripsi membutuhkan verifikasi oleh admin prodi.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-17-1">
    <h3 class="section-heading">Lihat Data Persetujuan KRS</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/persetujuankrs</small>
    </h4>
    <p>
      Melihat semua data Persetujuan KRS Mahasiswa sesuai program studi admin prodi
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Persetujuan KRS"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170001"</span>,
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Kukoh Santoso"</span>,
        },
        <span class="hljs-attr">"file_krs"</span>: {
          <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"krs-1412170001.jfif"</span>,
          <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileKRS/krs-1412170001.jfif"</span>,
        },
        <span class="hljs-attr">"tanggal_pengajuan_file_krs"</span>: <span class="hljs-string">"2021-05-14 00:10:41"</span>, 
        <span class="hljs-attr">"status_persetujuan_admin_prodi_file_krs"</span>: <span class="hljs-string">"Antrian"</span>, 
        <span class="hljs-attr">"catatan_file_krs"</span>: <span class="hljs-string">"-"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"mahasiswa"</span>: {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
          <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170003"</span>,
          <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Rohmadi"</span>,
        },
        <span class="hljs-attr">"file_krs"</span>: {
          <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"krs-1412170003.jfif"</span>,
          <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileKRS/krs-1412170003.jfif"</span>,
        },
        <span class="hljs-attr">"tanggal_pengajuan_file_krs"</span>: <span class="hljs-string">"2021-05-14 00:10:41"</span>, 
        <span class="hljs-attr">"status_persetujuan_admin_prodi_file_krs"</span>: <span class="hljs-string">"Antrian"</span>, 
        <span class="hljs-attr">"catatan_file_krs"</span>: <span class="hljs-string">"-"</span>, 
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
  <section class="docs-section pt-3" id="item-17-2">
    <h3 class="section-heading">Persetujuan KRS By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/persetujuankrs/{id}</small>
    </h4>
    <p>
      Melihat Data Persetujuan KRS Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Persetujuan KRS"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170003"</span>, 
        <span class="hljs-attr">"nama_mahasiswa"</span>: <span class="hljs-string">"Rohmadi"</span>, 
      }, 
      <span class="hljs-attr">"status_persetujuan_admin_prodi_file_krs"</span>: <span class="hljs-string">"Antrian"</span>, 
      <span class="hljs-attr">"catatan_file_krs"</span>: <span class="hljs-string">"-"</span>, 
      <span class="hljs-attr">"file"</span>: {
        <span class="hljs-attr">"nama_file"</span>: <span class="hljs-string">"krs-1412170003.jfif"</span>, 
        <span class="hljs-attr">"url"</span>: <span class="hljs-string">"fileKRS/krs-1412170003.jfif"</span>, 
      }
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-17-3">
    <h3 class="section-heading">Verifikasi Persetujuan KRS</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>adminprodi/persetujuankrs/{id}</small>
    </h4>
    <p>
      Proses Verifikasi Persetujuan KRS
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
        <h5>status_persetujuan_admin_prodi_file_krs
          <small>
            <sup class="text-danger">* required</sup> enum ('Antrian','Disetujui','Ditolak')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>catatan_file_krs
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Verification is successful"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"mahasiswa"</span>: {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">4</span>, 
        <span class="hljs-attr">"npm_mahasiswa"</span>: <span class="hljs-string">"1412170003"</span>, 
      }, 
      <span class="hljs-attr">"status_persetujuan_admin_prodi_file_krs"</span>: <span class="hljs-string">"Disetujui"</span>, 
      <span class="hljs-attr">"catatan_file_krs"</span>: <span class="hljs-string">"-"</span>, 
      <span class="hljs-attr">"updated_at"</span>: <span class="hljs-string">"1 detik yang lalu"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Edit -->
</article>