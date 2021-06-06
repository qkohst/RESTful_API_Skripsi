<article class="docs-article" id="section-5">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin/Fakultas</h1>
    <p>
      Mengelola data fakultas yang dilakukan oleh user dengan role Admin
    </p>
  </header>

  <!-- section Login -->
  <section class="docs-section pt-0" id="item-5-1">
    <h3 class="section-heading">Fakultas </h3>
    <h4>
      <span class="badge badge-primary">GET</span>
      <small>admin/fakultas</small>
    </h4>
    <p>
      Melihat semua data fakultas
    </p>
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
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>API Key dari project aplikasi anda, letakkan pada HTTP Header</td>
          </tr>
          <tr>
            <th class="theme-bg-light">api_token
              <small class="text-danger"> <sup>* required</sup></small>
              <h6>string <small><i>(header)</i></small></h6>
            </th>
            <td>API Token yang didapatkan dari proses login, letakkan pada HTTP Header</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--//table-responsive-->

    <h5 class="pt-2">Responses:</h5>
    <div class="table-responsive my-4">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Code</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>200</td>
            <td>OK
              <!--//table-responsive-->
              <div class="docs-code-block pt-0 pb-0">
                <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data"</span>,
    <span class="hljs-attr">"fakultas"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
        <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">14</span>, 
        <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Teknik"</span>, 
        <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FT"</span>, 
        <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>, 
        <span class="hljs-attr">"kode_fakultas"</span>: <span class="hljs-number">15</span>, 
        <span class="hljs-attr">"nama_fakultas"</span>: <span class="hljs-string">"Fakultas Keguruan dan Ilmu Pendidikan"</span>, 
        <span class="hljs-attr">"singkatan_fakultas"</span>: <span class="hljs-string">"FKIP"</span>, 
        <span class="hljs-attr">"status_fakultas"</span>: <span class="hljs-string">"Aktif"</span>
      }
    ]
  }
                  </code>
                </pre>
              </div>
              <!--//docs-code-block-->
            </td>
          <tr>
        </tbody>
      </table>
    </div>
  </section>
  <!--//section Login-->
</article>