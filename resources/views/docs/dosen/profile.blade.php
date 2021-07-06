<article class="docs-article" id="section-27">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Dosen/Profile</h1>
    <p>
      Mengelola data profile Dosen oleh user
    </p>
  </header>

  <!-- Lihat Profile -->
  <section class="docs-section pt-0" id="item-27-1">
    <h3 class="section-heading">Lihat Profile </h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>dosen/profile</small>
    </h4>
    <p>
      Melihat data profile Dosen
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
    "message": "Profile Dosen",
    "data": {
      "id": 10,
      "program_studi": {
        "id": 1,
        "kode_program_studi": 1412,
        "nama_program_studi": "Teknik Informatika"
      },
      "nama_dosen": "Andy Haryoko, ST.,M.T.",
      "nidn_dosen": "0726047704",
      "nip_dosen": "352305260477000109",
      "jenis_kelamin_dosen": "P",
      "tempat_lahir_dosen": "Nganjuk",
      "tanggal_lahir_dosen": "1997-04-26",
      "pendidikan_terakhir_dosen": "S2",
      "nik_dosen": "3523052604770001",
      "status_perkawinan_dosen": "Kawin",
      "agama_dosen": "Islam",
      "nama_ibu_dosen": "Lilik Sri Sukesi",
      "alamat_dosen": "Jl. KH. Wahid Hasyim 22B",
      "provinsi_dosen": {
        "id": null,
        "nama": null
      },
      "kabupaten_dosen": {
        "id": null,
        "nama": null
      },
      "kecamatan_dosen": {
        "id": null,
        "nama": null
      },
      "desa_dosen": {
        "id": null,
        "nama": null
      },
      "email_dosen": "andy.h@gmail.com",
      "no_hp_dosen": "0856986326587",
      "jabatan_fungsional": {
        "id": 1,
        "nama_jabatan_fungsional": "Dosen"
      },
      "jabatan_struktural": {
        "id": null,
        "nama_jabatan_struktural": null
      },
      "foto_dosen": {
        "nama_file": "img-0726047704.jpg",
        "url": "fileFotoProfile/img-0726047704.jpg"
      },
      "status_dosen": "Aktif",
      "tanggal_pembaruan_dosen": "2021-06-30 00:04:44"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Lihat Profile-->

  <!-- Update Profile -->
  <section class="docs-section pt-3" id="item-27-2">
    <h3 class="section-heading">Update Profile </h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>dosen/profile</small>
    </h4>
    <p>
      Merubah data profile Dosen
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
        <h5>status_perkawinan_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>jenis_kelamin_dosen
          <small>
            <sup class="text-danger">* required</sup> enum ('L','P')
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>nama_ibu_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>alamat_dosen
          <small>
            <sup class="text-danger"></sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>provinsi_dosen
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>kabupaten_dosen
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>kecamatan_dosen
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>desa_dosen
          <small>
            <sup class="text-danger">* required</sup> integer <i>($int32)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>email_dosen
          <small>
            <sup class="text-danger">* required</sup> string <i>(email)</i>
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>no_hp_dosen
          <small>
            <sup class="text-danger">* required</sup> string
          </small>
        </h5>
      </div>
      <div class="pt-3">
        <h5>foto_dosen
          <small>
            <sup class="text-danger">* required</sup> file <i>(image)</i>
          </small>
        </h5>
      </div>
    </div>

    <!-- Catatan Foreign Key -->
    <h5 class="mt-2">Catatan:</h5>
    <div class="alert alert-info" role="alert">
      Untuk body <code>provinsi_dosen, kabupaten_dosen, kecamatan_dosen,</code> dan <code>desa_dosen </code> memanfaatkan <a href="https://farizdotid.com/blog/dokumentasi-api-daerah-indonesia/" target="_black">API Daerah Indonesia</a> yang dikembangkan oleh <a href="https://farizdotid.com/blog/author/farizdotid/" target="_black">Farizdotid</a> Dokumentasi lengkapnya dapat anda baca <a href="https://farizdotid.com/blog/dokumentasi-api-daerah-indonesia/" target="_black">disini</a>
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
      "id": 10,
      "program_studi": {
        "id": 1,
        "kode_program_studi": 1412,
        "nama_program_studi": "Teknik Informatika"
      },
      "status_perkawinan_dosen": "Kawin",
      "jenis_kelamin_dosen": "L",
      "nama_ibu_dosen": "Lilik Sri Sukesi",
      "alamat_dosen": "Jl. KH. Wahid Hasyim 22B",
      "provinsi_dosen": {
        "id": 35,
        "nama": "Jawa Timur"
      },
      "kabupaten_dosen": {
        "id": 3509,
        "nama": "Kabupaten Jember"
      },
      "kecamatan_dosen": {
        "id": 3509160,
        "nama": "Jombang"
      },
      "desa_dosen": {
        "id": 3509160002,
        "nama": "Jombang"
      },
      "no_hp_dosen": "0856986326587",
      "email_dosen": "andy.h@gmail.com",
      "foto_dosen": {
        "nama_file": "img-14701201274.jpg",
        "url": "fileFotoProfile/img-14701201274.jpg"
      },
      "updated_at": "1 detik yang lalu"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//Akhir Update Profile-->

</article>