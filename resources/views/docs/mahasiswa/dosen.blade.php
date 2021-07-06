<article class="docs-article" id="section-21">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Dosen</h1>
    <p>
      Melihat data Dosen Aktif, data Dosen Pembimbing & data Dosen Penguji
    </p>
  </header>

  <!-- Lihat Profile -->
  <section class="docs-section pt-3" id="item-21-1">
    <h3 class="section-heading">Dosen By Status Aktif </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/dosen</small>
    </h4>
    <p>
      Melihat data dosen sesuai program studi mahasiswa yang berstatus Aktif, data ini dapat digunakan pada saat pemilihan dosen pembimbing pada proses <a class="scrollto" href="#section-22" target="_black">Persyaratan Skripsi</a>
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
    "status": "success",
    "message": "Data dosen at Teknik Informatika with an active status",
    "data": [
      {
        "id": 15,
        "nidn_dosen": "0724068909",
        "nama_dosen": "Andik Adi Suryanto, S.Kom.,M.Kom"
      },
      {
        "id": 10,
        "nidn_dosen": "0726047704",
        "nama_dosen": "Andy Haryoko, ST.,M.T."
      },
      {
        "id": 12,
        "nidn_dosen": "0716058402",
        "nama_dosen": "Aris Wijayanti, S.T.,M.T."
      },
      {
        "id": 14,
        "nidn_dosen": "0724068905",
        "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom"
      },
      {
        "id": 13,
        "nidn_dosen": "0714048502",
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T."
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

  <!-- Lihat Profile -->
  <section class="docs-section pt-3" id="item-21-2">
    <h3 class="section-heading">Lihat Data Dosen Pembimbing</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/dosenpembimbing</small>
    </h4>
    <p>
      Melihat data dosen pembimbing, data ini dapat digunakan pada saat proses <a class="scrollto" href="#section-23" target="_black">Bimbingan Proposal</a> dan <a class="scrollto" href="#section-25" target="_black">Bimbingan Skripsi</a>
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
    "status": "success",
    "message": "List of Data Dosen Pembimbing",
    "data": [
      {
        "id": 18,
        "dosen": {
          "id": 12,
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402"
        },
        "jabatan_dosen_pembimbing": "Pembimbing 1"
      },
      {
        "id": 19,
        "dosen": {
          "id": 14,
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905"
        },
        "jabatan_dosen_pembimbing": "Pembimbing 2"
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

  <!-- Lihat Profile -->
  <section class="docs-section pt-3" id="item-21-3">
    <h3 class="section-heading">Lihat Data Dosen Penguji</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/dosenpenguji</small>
    </h4>
    <p>
      Melihat data dosen penguji
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
    "status": "success",
    "message": "List of Data Dosen Penguji",
    "data": [
      {
        "id": 3,
        "dosen": {
          "id": 12,
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402"
        },
        "jabatan_dosen_penguji": "Penguji 1"
      },
      {
        "id": 4,
        "dosen": {
          "id": 13,
          "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
          "nidn_dosen": "0714048502"
        },
        "jabatan_dosen_penguji": "Penguji 2"
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

</article>