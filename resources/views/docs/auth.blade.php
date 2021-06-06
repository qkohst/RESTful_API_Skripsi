<article class="docs-article" id="section-4">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Auth</h1>
    <p>
      Esse nostrud reprehenderit mollit sint nostrud laboris adipisicing tempor dolore consectetur magna Lorem enim deserunt.
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
        </tbody>
      </table>
    </div>
    <!--//table-responsive-->
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
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Password change successfully."</span>,
    <span class="hljs-attr">"user"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">1</span>, 
      <span class="hljs-attr">"nama"</span>: <span class="hljs-string">"Kukoh Santoso"</span>, 
      <span class="hljs-attr">"username"</span>: <span class="hljs-string">"1412170001"</span>, 
      <span class="hljs-attr">"role"</span>: <span class="hljs-string">"Mahasiswa"</span>, 
      <span class="hljs-attr">"api_token"</span>: <span class="hljs-string">"$2y$10$hwEnAF73Yfl5yOgL39LLzuTrh1TS83kFVSXp/hojUD1tH3H6p.wSq"</span>
    }
  }
                  </code>
                </pre>
              </div>
              <!--//docs-code-block-->
            </td>
          <tr>

          <tr>
            <td>422</td>
            <td>Unprocessable Entity
              <!--//table-responsive-->
              <div class="docs-code-block pt-0 pb-0">
                <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"The given data was invalid"</span>,
    <span class="hljs-attr">"errors"</span>: {
      <span class="hljs-attr">"password"</span>: [
        <span class="hljs-string">"The password field is required."</span>
      ]
    }
  }
                  </code>
                </pre>
              </div>
              <!--//docs-code-block-->
            </td>
          <tr>

          <tr>
            <td>401</td>
            <td>Unauthorized
              <!--//table-responsive-->
              <div class="docs-code-block pt-0 pb-0">
                <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"errors"</span>: <span class="hljs-string">"Incorrect username or password"</span>
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
       <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Password change successfully."</span>
  }
                  </code>
                </pre>
              </div>
              <!--//docs-code-block-->
            </td>
          <tr>

          <tr>
            <td>422</td>
            <td>Unprocessable Entity
              <!--//table-responsive-->
              <div class="docs-code-block pt-0 pb-0">
                <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"The given data was invalid"</span>,
    <span class="hljs-attr">"errors"</span>: {
      <span class="hljs-attr">"confirm_password"</span>: [
        <span class="hljs-string">"The confirm password and password baru must match."</span>
      ]
    }
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
  <!--//section Ganti Password-->

  <!-- section Logout -->
  <section class="docs-section" id="item-4-3">
    <h3 class="section-heading">logout </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>auth/logout</small>
    </h4>
    <p>
      Logout
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
       <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Logout successfully."</span>
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
  <!--//section Logout-->

</article>