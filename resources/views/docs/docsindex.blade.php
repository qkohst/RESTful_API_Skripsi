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

  </header>
</article>