<article class="docs-article" id="section-6">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin/Fakultas</h1>
    <p>
      Mengelola data fakultas yang dilakukan oleh user dengan role Admin
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-6-1">
    <h3 class="section-heading">Lihat Data Fakultas </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/fakultas</small>
    </h4>
    <p>
      Melihat semua data fakultas
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Fakultas"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
        <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
        <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
        <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
        <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">15</span>, 
        <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Keguruan dan Ilmu Pendidikan"</span>, 
        <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FKIP"</span>, 
        <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Non Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-6-2">
    <h3 class="section-heading">Tambah Fakultas </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/fakultas</small>
    </h4>
    <p>
      Menambahkan data fakultas
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
        <h5>kode_fakultas
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_fakultas
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>singkatan_fakultas
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
      <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
      <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
      <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
      <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-6-3">
    <h3 class="section-heading">Fakultas By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/fakultas/{id}</small>
    </h4>
    <p>
      Melihat Data Fakultas Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Fakultas"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
      <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
      <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
      <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-6-4">
    <h3 class="section-heading">Update Fakultas </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/fakultas/{id}</small>
    </h4>
    <p>
      Update data fakultas
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
        <h5>nama_fakultas
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>singkatan_fakultas
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>status_fakultas
          <small>
            <sup class="text-danger">* required</sup> enum ('Aktif', 'Non Aktif')
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
      <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
      <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
      <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
      <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>, 
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
  <section class="docs-section pt-3" id="item-6-5">
    <h3 class="section-heading">Hapus Fakultas</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/fakultas/{id}</small>
    </h4>
    <p>
      Menghapus data fakultas
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data with id {id} deleted successfully"</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Hapus -->

  <!-- Fakultas  Aktif-->
  <section class="docs-section pt-3" id="item-6-6">
    <h3 class="section-heading">Fakultas Aktif</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/fakultas/aktif</small>
    </h4>
    <p>
      Melihat data fakultas dengan <code>status_fakultas</code> Aktif
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Data Fakultas with status active"</span>,
    <span class="hljs-attr">"data"</span>: [
        {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
          <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
          <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
          <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
        },
        {
          <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
          <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">15</span>, 
          <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Keguruan dan Ilmu Pendidikan"</span>, 
          <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FKIP"</span>, 
        }
      ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Aktif -->
</article>