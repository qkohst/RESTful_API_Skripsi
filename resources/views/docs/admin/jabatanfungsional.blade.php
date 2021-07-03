<article class="docs-article" id="section-9">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin/Jabatan Fungsional</h1>
    <p>
      Mengelola data Jabatan Fungsional yang dilakukan oleh user dengan role Admin
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-9-1">
    <h3 class="section-heading">Lihat Data Jabatan Fungsional</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/jabatanfungsional</small>
    </h4>
    <p>
      Melihat semua data Jabatan Fungsional
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Jabatan Fungsional"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Guru Besar"</span>, 
        <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi Jabatan Fungsional"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Asisten Ahli"</span>, 
        <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi Jabatan Fungsional"</span>, 
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
  <section class="docs-section pt-3" id="item-9-2">
    <h3 class="section-heading">Tambah Jabatan Fungsional </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/jabatanfungsional</small>
    </h4>
    <p>
      Menambahkan data Jabatan Fungsional
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
        <h5>nama_jabatan_fungsional
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>deskripsi_jabatan_fungsional
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
      <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Asisten Ahli"</span>, 
      <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi Jabatan Fungsional"</span>, 
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
  <section class="docs-section pt-3" id="item-9-3">
    <h3 class="section-heading">Jabatan Fungsional By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>admin/jabatanfungsional/{id}</small>
    </h4>
    <p>
      Melihat Data Jabatan Fungsional Berdasarkan ID
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Details Data Jabatan Fungsional"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">15</span>, 
      <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Asisten Ahli"</span>, 
      <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi Jabatan Fungsional"</span>, 
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
  </section>
  <!--//section Fakulltas By ID  -->

  <!-- Update Fakultas  -->
  <section class="docs-section pt-3" id="item-9-4">
    <h3 class="section-heading">Update Jabatan Fungsional </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/jabatanfungsional/{id}</small>
    </h4>
    <p>
      Update Data Jabatan Fungsional
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
        <h5>deskripsi_jabatan_fungsional
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
      <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Asisten Ahli"</span>, 
      <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi Jabatan Fungsional"</span>, 
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
  <section class="docs-section pt-3" id="item-9-5">
    <h3 class="section-heading">Hapus Jabatan Fungsional</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>admin/jabatanfungsional/{id}</small>
    </h4>
    <p>
      Menghapus Data Jabatan Fungsional
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
</article>