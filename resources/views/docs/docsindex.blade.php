<article class="docs-article" id="section-3">
  <header class="docs-header">
    <h1 class="docs-heading">Dokumentasi</h1>

    <h5>Server : </h5>
    <p>
      http://127.0.0.1:8000/api/v1
    </p>
    <p>
      Berikut adalah struktur response yang akan anda dapatkan saat melakukan request :
    </p>

    <!-- Response Success -->
    <h5 class="pt-2">Response Success:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"success"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"pesan keterangan response"</span>,
    <span class="hljs-attr">"data"</span>: {
      <span class="hljs-attr">"id"</span>: <span class="hljs-number">value</span>, 
      <span class="hljs-attr">"key"</span>: <span class="hljs-string">"value"</span>
    }
  }
                  </code>
                </pre>
    </div>

    <!-- Response Error -->
    <h5 class="pt-0">Response Error:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    <span class="hljs-attr">"status"</span>: <span class="hljs-string">"error"</span>,
    <span class="hljs-attr">"message"</span>: <span class="hljs-string">"pesan keterangan response"</span>,
  }
                  </code>
                </pre>
    </div>

    <!-- HTTP Status Code-->
    <h5 class="pt-2">HTTP Status Code:</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Kode</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="theme-bg-light">200
              <h6>OK</h6>
            </th>
            <td>
              Permintaan berhasil dijalankan.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">201
              <h6>Created</h6>
            </th>
            <td>
              Permintaan berhasil dan data baru berhasil ditambahkan.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">205
              <h6>Reset Content</h6>
            </th>
            <td>
              Permintaan reset data berhasil.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">400
              <h6>Bad Request</h6>
            </th>
            <td>
              Permintaan tidak dapat diterima, biasanya karena parameter yang hilang atau kesalahan dikonfigurasi.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">401
              <h6>Unauthorized/Unauthenticated</h6>
            </th>
            <td>
              Kesalahan pada <b>api_key</b> atau <b>api_token</b> yang tidak valid atau non aktif.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">404
              <h6>Not Found</h6>
            </th>
            <td>
              Kesalahan pada kode respons client sehingga server tidak dapat menemukan data yang diminta.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">409
              <h6>Conflict</h6>
            </th>
            <td>
              Menunjukkan konflik permintaan atau data ganda dengan status sumber daya target yang dikirim.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">422
              <h6>Unprocessable Entity</h6>
            </th>
            <td>
              Server tidak dapat memproses data yang dikirimkan, ini biasanya terjadi karena kesalahan pada format isian data yang dikirim.
            </td>
          </tr>
          <tr>
            <th class="theme-bg-light">500
              <h6>Server Error</h6>
            </th>
            <td>
              Terdapat masalah pada sisi server.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </header>
</article>