<article class="docs-article" id="section-22">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Persyaratan Skripsi</h1>
    <p>
      Pada tahap awal mahasiswa yang akan mengambil mata kuliah skripsi, harus mengunggah file scan KRS yang mencantumkan mata kuliah Tugas Akhir (Skripsi).
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-22-1">
    <h3 class="section-heading">Upload KRS</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/persyaratan/uploadkrs</small>
    </h4>
    <p>
      Upload file KRS dengan mata kuliah Tugas Akhir (Skripsi)
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
      <div class="pt-3">
        <h5>file_krs
          <small>
            <sup class="text-danger">* required</sup> file (image)
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
    "status": "success",
    "message": "File uploaded successfully",
    "data": {
      "id": 9,
      "file": {
        "nama_file": "krs-1412160002.jpg",
        "url": "fileKRS/krs-1412160002.jpg"
      },
      "created_at": "1 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->


  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-22-2">
    <h3 class="section-heading">Status Verifikasi Upload KRS</h3>
    <h4>
      <span class="badge badge-primary">GET</span>
      <small>mahasiswa/persyaratan/uploadkrs</small>
    </h4>
    <p>
      Melihat status verifikasi admin prodi file KRS yang telah diupload.
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
    "message": "KRS File Verification Status",
    "data": {
      "id": 1,
      "file_krs": {
        "nama_file": "krs-1412170001.jpg",
        "url": "fileKRS/krs-1412170001.jpg"
      },
      "status_persetujuan_admin_prodi_file_krs": "Disetujui",
      "catatan_file_krs": "-",
      "tanggal_pengajuan_file_krs": "2021-05-13 23:33:14"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-22-3">
    <h3 class="section-heading">Pengajuan Judul Ke Pembimbing 1</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/persyaratan/juduldosbig1</small>
    </h4>
    <p>
      Mengajukan judul skripsi ke dosen pembimbing 1
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
        <h5>nama_judul_Skripsi
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>dosen_id_dosen
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id dosen dengan status aktif dapat anda lihat pada endpoint <a class="scrollto" href="#item-21-1" target="_black">Dosen By Status Aktif</a>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Data has been submitted",
    "data": {
      "id": 9,
      "nama_judul_skripsi": "Analisa Mengenai Efisiensi Penggunaan Modal Kerja pada CV. Anugerah Ditinjau Dari Segi Profitabilitas Dan Likuiditas s",
      "dosen_pembimbing": {
        "id": "14",
        "nama_dosen_pembimbing": "Asfan Muqtadir, S.Kom.,M.Kom",
        "jabatan_dosen_pembibing": "1",
        "persetujuan_dosen_pembimbing": "Antrian"
      },
      "created_at": "2021-07-01T15:36:06Z"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-22-4">
    <h3 class="section-heading">Status Persetujuan Pembimbing 1</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/persyaratan/juduldosbing1</small>
    </h4>
    <p>
      Melihat status pengajuan judul ke dosen pembimbing 1
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
    "message": "Submission status",
    "data": {
      "id": 5,
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "nama_dosen_pembimbing1": "Andy Haryoko, ST.,M.T.",
      "nidn_dosen_pembimbing1": "0726047704",
      "persetujuan_dosen_pembimbing1": "Disetujui",
      "catatan_dosen_pembimbing1": "-",
      "tanggal_pengajuan_dosen_pembimbing1": "2021-05-14 22:17:58"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-22-5">
    <h3 class="section-heading">Pengjuan Judul Ke Pembimbing 2</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/persyaratan/juduldosbing2</small>
    </h4>
    <p>
      Setelah menadapatkan persetujuan dari pembimbing 1, mahasiswa dapat mengajukan Judul dan Memilih Dosen Pembimbing 2.
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
        <h5>dosen_id_dosen
          <small>
            <sup class="text-danger">* required</sup> integer<i>($int32)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk mendapatkan list data id dosen dengan status aktif dapat anda lihat pada endpoint <a class="scrollto" href="#item-21-1" target="_black">Dosen By Status Aktif</a>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Data has been submitted",
    "data": {
      "id": 16,
      "judul_skripsi": {
        "id": 11,
        "nama_judul_skripsi": "sjdosodjs nksdishdsdnsd"
      },
      "dosen": {
        "id": 12,
        "nama_dosen": "Aris Wijayanti, S.T.,M.T."
      },
      "jabatan_dosen_pembimbing": "2",
      "persetujuan_dosen_pembimbing": "Antrian",
      "created_at": "2021-07-01T16:25:51Z"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-22-6">
    <h3 class="section-heading">Status Persetujuan Pembimbing 2</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/persyaratan/juduldosbing2</small>
    </h4>
    <p>
      Melihat status pengajuan judul ke dosen pembimbing 2
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
    "message": "Submission status",
    "data": {
      "id": 9,
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "nama_dosen_pembimbing2": "Asfan Muqtadir, S.Kom.,M.Kom",
      "nidn_dosen_pembimbing2": "0724068905",
      "persetujuan_dosen_pembimbing2": "Disetujui",
      "catatan_dosen_pembimbing2": "-",
      "tanggal_pengajuan_dosen_pembimbing2": "2021-05-20 12:55:06"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->
</article>