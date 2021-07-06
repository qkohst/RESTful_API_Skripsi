<article class="docs-article" id="section-24">
  <header class="docs-header">
    <h1 class="docs-heading pb-0">Mahasiswa/Seminar Proposal</h1>
    <p>
      Setelah proses bimbingan proposal selesai, mahasiswa dapat mengjukan seminar proposal.
    </p>
  </header>

  <!-- Lihat Fakultas  -->
  <section class="docs-section pt-0" id="item-24-1">
    <h3 class="section-heading">Pengajuan Seminar Proposal</h3>
    <h4>
      <span class="badge badge-primary">POST</span>
      <small>mahasiswa/seminarproposal</small>
    </h4>
    <p>
      Pengajuan seminar proposal dengan mengunggah file proposal skripsi, untuk kemudian menunggu persetujuan dosen pembimbing.
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
        <h5>file_seminar_proposal
          <small>
            <sup class="text-danger">* required</sup> file (.pdf)
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
      "id": 5,
      "judul_skripsi": {
        "id": 12,
        "nama_judul_skripsi": "Indonesia Raya"
      },
      "file_seminar_proposal": {
        "nama_file": "seminar-1412160002.pdf",
        "url": "fileSeminar/seminar-1412160002.pdf"
      },
      "status_seminar_proposal": "Pengajuan",
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
  <section class="docs-section pt-3" id="item-24-2">
    <h3 class="section-heading">Status Persetujuan Dosen Pembimbing</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/seminarproposal/persetujuandosbing</small>
    </h4>
    <p>
      Melihat status persetujuan seminar proposal oleh dosen pembimbing, yang mana jika terdapat salah satu status persetujuan yang ditolak, mahasiswa harus melakukan pengajuan seminar proposal ulang.
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
      "id": 6,
      "judul_skripsi": {
        "id": 12,
        "nama_judul_skripsi": "Indonesia Raya"
      },
      "persetujuan_pembimbing1_seminar_proposal": "Antrian",
      "catatan_pembimbing1_seminar_proposal": null,
      "persetujuan_pembimbing2_seminar_proposal": "Antrian",
      "catatan_pembimbing2_seminar_proposal": null,
      "tanggal_pengajuan_seminar_proposal": "2021-07-02 18:40:49"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-24-3">
    <h3 class="section-heading">Dosen Penguji dan Waktu Seminar</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/seminarproposal/penguji</small>
    </h4>
    <p>
      Melihat data dosen penguji, waktu dan tempat seminar proposal yang telah ditnetukan oleh admin prodi.
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
    "message": "Information of Penguji & Waktu Seminar",
    "data": {
      "id": 2,
      "dosen_penguji1_seminar_proposal": {
        "id": 3,
        "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
        "nidn_dosen": "0716058402"
      },
      "dosen_penguji2_seminar_proposal": {
        "id": 4,
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
        "nidn_dosen": "0714048502"
      },
      "waktu_seminar_proposal": "2021-05-27 08:00:00",
      "tempat_seminar_proposal": "Lab Data Mining"
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-24-4">
    <h3 class="section-heading">Hasil Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilseminarproposal</small>
    </h4>
    <p>
      Melihat data hasil verifikasi pelaksanaan seminar proposal oleh dosen pembimbing dan dosen penguji.
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
    "message": "List of Data Hasil Seminar Proposal",
    "data": [
      {
        "id": 1,
        "dosen": {
          "id": 10,
          "nama_dosen": "Andy Haryoko, ST.,M.T.",
          "nidn_dosen": "0726047704",
          "status_dosen": "Pembimbing 1"
        },
        "status_verifikasi_hasil_seminar_proposal": "Revisi",
        "catatan_hasil_seminar_proposal": "Elit pariatur fugiat occaecat cillum duis esse fugiat minim aliquip veniam enim."
      },
      {
        "id": 2,
        "dosen": {
          "id": 12,
          "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
          "nidn_dosen": "0716058402",
          "status_dosen": "Penguji 1"
        },
        "status_verifikasi_hasil_seminar_proposal": "Lulus Seminar",
        "catatan_hasil_seminar_proposal": "Tempor dolore exercitation elit sint amet incididunt."
      },
      {
        "id": 3,
        "dosen": {
          "id": 14,
          "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
          "nidn_dosen": "0724068905",
          "status_dosen": "Pembimbing 2"
        },
        "status_verifikasi_hasil_seminar_proposal": "Revisi",
        "catatan_hasil_seminar_proposal": "Reprehenderit qui do irure dolore cillum culpa pariatur excepteur anim non eu eu."
      },
      {
        "id": 4,
        "dosen": {
          "id": 13,
          "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
          "nidn_dosen": "0714048502",
          "status_dosen": "Penguji 2"
        },
        "status_verifikasi_hasil_seminar_proposal": "Lulus Seminar",
        "catatan_hasil_seminar_proposal": "Minim ullamco aliquip non ex consectetur pariatur incididunt cillum labore amet aute labore."
      }
    ]
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-24-5">
    <h3 class="section-heading">Hasil Seminar Proposal By ID</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilseminarproposal/{id}</small>
    </h4>
    <p>
      Melihat data hasil seminar proposal berdasarkan ID. Data ini dapat digunakan untuk melihat detail revisi hasil pelaksanaan seminar proposal.
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
    "message": "Details Hasil Seminar Proposal",
    "data": {
      "id": 4,
      "dosen": {
        "id": 13,
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
        "nidn_dosen": "0714048502",
        "status_dosen": "Penguji 2"
      },
      "status_verifikasi_hasil_seminar_proposal": "Revisi",
      "catatan_hasil_seminar_proposal": "Nulla ut minim cillum elit dolore sit."
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->

  </section>
  <!--//section-->

  <!-- Awal Section  -->
  <section class="docs-section pt-3" id="item-24-6">
    <h3 class="section-heading">Nilai Seminar Proposal</h3>
    <h4>
      <span class="badge badge-info">GET</span>
      <small>mahasiswa/hasilseminarproposal/daftarnilai</small>
    </h4>
    <p>
      Melihat data nilai hasil pelaksaan seminar proposal.
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
    "message": "List of Data Rekap Nilai Seminar Proposal",
    "data": {
      "id": 2,
      "mahasiswa": {
        "id": 2,
        "nama_mahasiswa": "Kukoh Santoso",
        "npm_mahasiswa": "1412170001"
      },
      "program_studi": {
        "id": 1,
        "fakultas_program_studi": "Fakultas Teknik",
        "nama_program_studi": "Teknik Informatika"
      },
      "judul_skripsi": {
        "id": 5,
        "nama_judul_skripsi": "Perancangan dan Iplementasi RESTful API Pada Sistem Monitoring dan Evaluasi Tugas Akhir Mahasiswa"
      },
      "waktu_seminar_proposal": "2021-05-27 08:00:00",
      "tempat_seminar_proposal": "Lab Data Mining",
      "dosen_pembimbing_1": {
        "id": 10,
        "nama_dosen": "Andy Haryoko, ST.,M.T.",
        "nidn_dosen": "0726047704"
      },
      "dosen_pembimbing_2": {
        "id": 14,
        "nama_dosen": "Asfan Muqtadir, S.Kom.,M.Kom",
        "nidn_dosen": "0724068905"
      },
      "dosen_penguji_1": {
        "id": 12,
        "nama_dosen": "Aris Wijayanti, S.T.,M.T.",
        "nidn_dosen": "0716058402"
      },
      "dosen_penguji_2": {
        "id": 13,
        "nama_dosen": "Fitroh Amaluddin, S.T.,M.T.",
        "nidn_dosen": "0714048502"
      },
      "rekap_nilai_seminar_proposal": {
        "rata2_nilai_a_hasil_seminar_proposal": 84,
        "rata2_nilai_b_hasil_seminar_proposal": 84,
        "rata2_nilai_c_hasil_seminar_proposal": 85,
        "jumlah_rata2_nilai_hasil_seminar_proposal": 252,
        "nilai_akhir_hasil_seminar_proposal": 84
      }
    }
  }
                  </code>
                </pre>
    </div>
    <!-- Akhir Response -->
    
    <!-- Keterangan Nilai -->
    <h5 class="mt-0">Keterangan Nilai:</h5>
    <div class="alert alert-info" role="alert">
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>Nilai A</th>
            <td>
              Nilai Proses Bimbingan Proposal / Skripsi
            </td>
          </tr>
          <tr>
            <th>Nilai B</th>
            <td>
              Nilai Naskah Proposal / Skripsi
            </td>
          </tr>
          <tr>
            <th>Nilai C</th>
            <td>
              Nilai Pelaksanaan Seminar Proposal / Sidang Skripsi
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </section>
  <!--//section-->
</article>