<article class="docs-article" id="section-20">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Profile</h1>
    <p>
      Mengelola data profile Mahasiswa oleh user
    </p>
  </header>

  <!-- Lihat Profile -->
  <section class="docs-section pt-0" id="item-20-1">
    <h3 class="section-heading">Lihat Profile </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/profile</small>
    </h4>
    <p>
      Melihat data profile Mahasiswa
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
    "message": "Profile Mahasiswa",
    "data": {
      "id": 2,
      "program_studi": {
        "id": 1,
        "kode_program_studi": 1412,
        "nama_program_studi": "Teknik Informatika"
      },
      "nama_mahasiswa": "Kukoh Santoso",
      "npm_mahasiswa": "1412170001",
      "semester_mahasiswa": 8,
      "jenis_kelamin_mahasiswa": "L",
      "tempat_lahir_mahasiswa": "Tuban",
      "tanggal_lahir_mahasiswa": "1997-05-30",
      "status_perkawinan_mahasiswa": "Belum Kawin",
      "agama_mahasiswa": "Islam",
      "nama_ibu_mahasiswa": "Darmini",
      "alamat_mahasiswa": "RT.011/RW.004",
      "provinsi_mahasiswa": {
        "id": 32,
        "nama": "Jawa Barat"
      },
      "kabupaten_mahasiswa": {
        "id": 3201,
        "nama": "Kabupaten Bogor"
      },
      "kecamatan_mahasiswa": {
        "id": 3214080,
        "nama": "Wanayasa"
      },
      "desa_mahasiswa": {
        "id": 3214010006,
        "nama": "Jatimekar"
      },
      "email_mahasiswa": "kukohsantoso013@gmail.com",
      "no_hp_mahasiswa": "085232077932",
      "status_mahasiswa": "Lulus",
      "foto_mahasiswa": {
        "nama_file": "img-1412170001.png",
        "url": "fileFotoProfile/img-1412170001.png"
      },
      "tanggal_pembaruan_mahasiswa": "2021-06-30 21:35:39"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

  <!-- Update Profile -->
  <section class="docs-section pt-3" id="item-20-2">
    <h3 class="section-heading">Update Profile </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/profile</small>
    </h4>
    <p>
      Merubah data profile Mahasiswa
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
        <h5>status_perkawinan_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum ('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>agama_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum ('Islam','Protestan','Katolik','Hindu','Budha','Khonghucu','Kepercayaan')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jenis_kelamin_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> enum ('L','P')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_ibu_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>alamat_mahasiswa
          <small>
            <sup class="text-danger"></sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>provinsi_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>kabupaten_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>kecamatan_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>desa_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>email_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string <i>(email)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>no_hp_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>foto_mahasiswa
          <small>
            <sup class="text-danger">* required</sup> file <i>(image)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk body <code>provinsi_mahasiswa, kabupaten_mahasiswa, kecamatan_mahasiswa,</code> dan <code>desa_mahasiswa </code> memanfaatkan <a href="https://farizdotid.com/blog/dokumentasi-api-daerah-indonesia/" target="_black">API Daerah Indonesia</a> yang dikembangkan oleh <a href="https://farizdotid.com/blog/author/farizdotid/" target="_black">Farizdotid</a> Dokumentasi lengkapnya dapat anda baca <a href="https://farizdotid.com/blog/dokumentasi-api-daerah-indonesia/" target="_black">disini</a>
    </div>

    <!-- Response -->
    <h5 class="pt-2">Responses:</h5>
    <div class="docs-code-block pt-0 pb-0">
      <pre class="rounded">
                  <code class="json hljs">
  {
    "status": "success",
    "message": "Profile updated successfully",
    "data": {
      "id": 2,
      "program_studi": {
        "id": 1,
        "kode_program_studi": 1412,
        "nama_program_studi": "Teknik Informatika"
      },
      "status_perkawinan_mahasiswa": "Belum Kawin",
      "agama_mahasiswa": "Islam",
      "jenis_kelamin_mahasiswa": "L",
      "nama_ibu_mahasiswa": "Darmini",
      "alamat_mahasiswa": "RT.011/RW.004",
      "provinsi_mahasiswa": {
        "id": 32,
        "nama": "Jawa Barat"
      },
      "kabupaten_mahasiswa": {
        "id": 3201,
        "nama": "Kabupaten Bogor"
      },
      "kecamatan_mahasiswa": {
        "id": 3214080,
        "nama": "Wanayasa"
      },
      "desa_mahasiswa": {
        "id": 3214010006,
        "nama": "Jatimekar"
      },
      "no_hp_mahasiswa": "085232077932",
      "email_mahasiswa": "kukohsantoso013@gmail.com",
      "foto_mahasiswa": {
        "nama_file": "img-1412170001.png",
        "url": "fileFotoProfile/img-1412170001.png"
      },
      "updated_at": "2 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Update Profile-->

</article>