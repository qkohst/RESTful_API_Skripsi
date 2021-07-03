<article class="docs-article" id="section-4">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Auth</h1>
    <p>
      Selain API Key anda juga membutuhkan <b>API Token</b> sebagai <b>Authorisasi</b> pada setiap endpoint yang ada, Api Token didapatkan pada proses login.
    </p>
  </header>

  <!-- section Login -->
  <section class="docs-section pt-0" id="item-4-1">
    <h3 class="section-heading">Login </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>auth/login</small>
    </h4>
    <p>
      Login dengan menggunakan username dan password untuk mendapatkan api_token.
    </p>
    <p>
      Terdapat 4 level user yaitu Admin, Admin Prodi, Mahasiswa, dan Dosen. Untuk mendapat <code>username</code> dan <code>password</code> login silahkan hubungi <a href="https://www.instagram.com/qkoh_st" target="_black">tim kami</a>.
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
    <!--//table-responsive-->

    <!-- Request Body -->
    <h5 class="pt-2">Request body:</h5>
    <div class="callout-block callout-block-success">
      <div class="pt-0">
        <h5>username
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>password
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Login successfully"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1412170001"</span>, 
      <span class="hljs-attr">"role"</span>: <span class="hljs-string">"Mahasiswa"</span>, 
      <span class="hljs-attr">"api_token"</span>: <span class="hljs-string">"TamWyNRKuwjqSt35aCcFkkC2yR9VNhnxZXKBUcPeGXYyA83qVCVZypUkroAOemWm2AxYmtPJ99mO3Hi12fVnOuVmA3tUxQzjQnvm"</span>
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Login-->


  <!-- section Ganti Password -->
  <section class="docs-section" id="item-4-2">
    <h3 class="section-heading">Ganti Password </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>auth/gantipassword</small>
    </h4>
    <p>
      Mengganti password pengguna
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
        <h5>username
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>password_lama
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>password_baru
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>confirm_password
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Password change successfully."</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Ganti Password-->

  <!-- section Logout -->
  <section class="docs-section" id="item-4-3">
    <h3 class="section-heading">logout </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>auth/logout</small>
    </h4>
    <p>
      User Logout
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Logout successfully."</span>,
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section Logout-->

</article>