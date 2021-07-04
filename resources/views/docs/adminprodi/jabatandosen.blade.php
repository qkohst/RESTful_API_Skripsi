<article class="docs-article" id="section-16">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Admin Prodi/Jabatan Dosen</h1>
    <p>
      Melihat data Jabatan Struktural dan Jabatan Fungsional yang dilakukan oleh user dengan role Admin Prodi, ini dapat anda gunakan sebagai data <code>select</code> untuk droupdown menu saat proses tambah atau edit data dosen.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-16-1">
    <h3 class="section-heading">Lihat Jabatan Struktural</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/jabatanstruktural</small>
    </h4>
    <p>
      Melihat semua data Jabatan Struktural
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"List of Data Jabatan Struktural"</span>,
    <span class="hljs-attr">"data"</span>: [
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>,
        <span class="hljs-attr">"nama_jabatan_struktural"</span>: <span class="hljs-string">"Kepala Lab"</span>, 
        <span class="hljs-attr">"deskripsi_jabatan_struktural"</span>: <span class="hljs-string">"Deskripsi"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"nama_jabatan_struktural"</span>: <span class="hljs-string">"Wakil Rektor 1"</span>, 
        <span class="hljs-attr">"deskripsi_jabatan_struktural"</span>: <span class="hljs-string">"Deskripsi"</span>, 
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-3" id="item-16-2">
    <h3 class="section-heading">Lihat Jabatan Fungsional</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>adminprodi/jabatanfungsional</small>
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
        <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi"</span>, 
      },
      {
        <span class="hljs-attr">"id"</span>: <span class="hljs-number">2</span>,
        <span class="hljs-attr">"nama_jabatan_fungsional"</span>: <span class="hljs-string">"Lektor"</span>, 
        <span class="hljs-attr">"deskripsi_jabatan_fungsional"</span>: <span class="hljs-string">"Deskripsi"</span>, 
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