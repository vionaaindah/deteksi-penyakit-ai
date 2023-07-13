<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
    <Style>
        #question {
            background: #ffecdb;
        }

        #ques {
            color: #105461;
        }

        #ket {
            color: #105461;
            margin-bottom: 0;
        }

        .btn {
            border: 2px solid #319ca6;
            color: #319ca6;
            margin-left: 43%;
        }

        .option:hover {
            box-shadow: 0 0 40px 40px #319ca6 inset;
        }

        .btn:hover,
        .btn:focus {
            color: #105461;
        }
    </Style>
</head>

<body>

    <div id="content">
        <div id="question">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <div id='ket'>
                    <h2>Pemeriksaan Keluhan dan Gejala</h2>
                </div>
                <div id="ques">
                    <p>G1. Apakah badan anda panas?</p>
                    <label><input type="radio" value="Iya" name="g1" required>Iya</label>
                    <label><input type="radio" value="Tidak" name="g1">Tidak</label>
                </div>
                <br />
                <div id="ques">
                    <p>G2. Apakah anda mengalami sakit kepala?</p>
                    <label><input type="radio" value="Iya" name="g2" required>Iya</label>
                    <label><input type="radio" value="Tidak" name="g2">Tidak</label>
                </div>
                <br />
                <div id="ques">
                    <p>G3. Apakah anda mengalami bersin-bersin?</p>
                    <label><input type="radio" value="Iya" name="g3" required>Iya</label>
                    <label><input type="radio" value="Tidak" name="g3">Tidak</label>
                </div>
                <br />
                <div id="ques">
                    <p>G4. Apakah anda mengalami batuk?</p>
                    <label><input type="radio" value="Iya" name="g4" required>Iya</label>
                    <label><input type="radio" value="Tidak" name="g4">Tidak</label>
                </div>
                <br />
                <div id="ques">
                    <p>G5. Apakah anda mengalami pilek atau hidung tersumbat?</p>
                    <label><input type="radio" value="Iya" name="g5" required>Iya</label>
                    <label><input type="radio" value="Tidak" name="g5">Tidak</label>
                </div>
                <input class="btn option" type="submit" value="Submit" />
            </form>
        </div>

        <div id="image">
            <h1>Diagnosa Penyakit menggunakan Metode Dempster-Shafer</h1>
            <img src="https://www.twistbioscience.com/sites/default/files/2021-04/iStock-1221259536.jpg" alt="Covid">

            <div id="hasil">

            </div>
        </div>
    </div>


    <?php
    $ket = "Result :";
    $kategori = "Hasil Pemeriksaan Anda akan Tampil di sini";
    $penyakit = $hasil  = $percent = "";

    if (isset($_POST['g1'])) {
        $g1 = $_POST['g1'];
        $g2 = $_POST['g2'];
        $g3 = $_POST['g3'];
        $g4 = $_POST['g4'];
        $g5 = $_POST['g5'];
        $percent = "%";


        if ($g1 == "Iya") {
            $m1BDF = "B,D,F";
            $bobotm1BDF = 0.4;
            $bobotm1 = 0.6;

            // Hasil Diagnosa Jika Memilih Gejala Badan Panas
            $kategori = "Penyakit Bronkitis, Demam, Flu";
            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
            $hasil = $bobotm1BDF * 100;

            if ($g2 == "Iya") {
                $m2AF = "A,F";
                $bobotm2AF = 0.5;
                $bobotm2 = 0.5;

                $m3F = $bobotm1BDF * $bobotm2AF;
                $m3BDF = $bobotm1BDF * $bobotm2;
                $m3AF = $bobotm1 * $bobotm2AF;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Badan Panas dan Sakit Kepala
                if ($m3F > $m3BDF) {
                    if ($m3F > $m3AF) {
                        $kategori = "Penyakit Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m3F * 100;
                    }
                } elseif ($m3BDF > $m3AF) {
                    $kategori = "Penyakit Bronkitis, Demam, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BDF * 100;
                } else {
                    $kategori = "Penyakit Anemia, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3AF * 100;
                }

                if ($g3 == "Iya") {
                    $m4BF = "B,F";
                    $bobotm4BF = 0.6;
                    $m4 = 0.4;

                    $m5F = ($m3F * $bobotm4BF) + ($m3AF * $bobotm4BF) + ($m3F * $m4);
                    $m5AF = $m3AF * $m4;
                    $m5BDF = $m3BDF * $m4;
                    $m5BF = ($m3BDF * $bobotm4BF) + ($m3 * $bobotm4BF);
                    $m5 = $m3 * $m4;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala dan Bersin-Bersin
                    if ($m5F > $m5AF) {
                        if ($m5F > $m5BDF) {
                            if ($m5F > $m5BF) {
                                $kategori = "Penyakit Flu";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                $hasil = $m5F * 100;
                            }
                        }
                    } elseif ($m5AF > $m5BDF) {
                        if ($m5AF > $m5BF) {
                            $kategori = "Penyakit Anemia, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5AF * 100;
                        }
                    } elseif ($m5BDF > $m5BF) {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    }

                    if ($g4 == "Iya") {
                        $m6B = "B";
                        $bobotm6B = 0.4;
                        $m6 = 0.6;

                        $per = 1 - (($bobotm6B * $m5F) + ($bobotm6B * $m5AF));;

                        $m7B = (($bobotm6B * $m5BDF) + ($bobotm6B * $m5BF) + ($bobotm6B * $m5)) / $per;
                        $m7F = ($m5F * $m6) / $per;
                        $m7AF = ($m5AF * $m6) / $per;
                        $m7BDF = ($m5BDF * $m6) / $per;
                        $m7BF = ($m5BF * $m6) / $per;
                        $m7 = ($m5 * $m6) / $per;

                        // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala, Bersin-Bersin dan Batuk
                        if ($m7B > $m7F) {
                            if ($m7B > $m7AF) {
                                if ($m7B > $m7BDF) {
                                    if ($m7B > $m7BF) {
                                        $kategori = "Penyakit Bronkitis";
                                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                        $hasil = $m7B * 100;
                                    }
                                }
                            }
                        } elseif ($m7F > $m7AF) {
                            if ($m7F > $m7BDF) {
                                if ($m7F > $m7BF) {
                                    $kategori = "Penyakit Flu";
                                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                    $hasil = $m7F * 100;
                                }
                            }
                        } elseif ($m7AF > $m7BDF) {
                            if ($m7AF > $m7BF) {
                                $kategori = "Penyakit Anemia, Flu";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                                $hasil = $m7AF * 100;
                            }
                        } elseif ($m7BDF > $m7BF) {
                            $kategori = "Penyakit Bronkitis, Demam, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BDF * 100;
                        } else {
                            $kategori = "Penyakit Bronkitis, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BF * 100;
                        }

                        if ($g5 == "Iya") {
                            $m8F = "F";
                            $bobotm8F = 0.8;
                            $m8 = 0.2;

                            $per = 1 - ($m7B * $bobotm8F);

                            $m9F = (($bobotm8F * $m7F) + ($bobotm8F * $m7BF) + ($bobotm8F * $m7AF) + ($bobotm8F * $m7BDF) + ($bobotm8F * $m7) + ($m7F * $m8)) / $per;
                            $m9B = ($m7B * $m8) / $per;
                            $m9AF = ($m7AF * $m8) / $per;
                            $m9BDF = ($m7BDF * $m8) / $per;
                            $m9BF = ($m7BF * $m8) / $per;
                            $m9 = ($m7 * $m8) / $per;

                            // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala, Bersin-Bersin, Batuk dan Pilek atau Hidung Tersumbat
                            if ($m9F > $m9B) {
                                if ($m9F > $m9AF) {
                                    if ($m9F > $m9BDF) {
                                        if ($m9F > $m9BF) {
                                            $kategori = "Penyakit Flu";
                                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                            $hasil = $m9F * 100;
                                        }
                                    }
                                }
                            } elseif ($m9B > $m9AF) {
                                if ($m9B > $m9BDF) {
                                    if ($m9B > $m9BF) {
                                        $kategori = "Penyakit Bronkitis";
                                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                        $hasil = $m9B * 100;
                                    }
                                }
                            } elseif ($m9AF > $m9BDF) {
                                if ($m9AF > $m9BF) {
                                    $kategori = "Penyakit Anemia, Flu";
                                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                                    $hasil = $m9AF * 100;
                                }
                            } elseif ($m9BDF > $m9BF) {
                                $kategori = "Penyakit Bronkitis, Demam, Flu";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                                $hasil = $m9BDF * 100;
                            } else {
                                $kategori = "Penyakit Bronkitis, Flu";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                                $hasil = $m9BF * 100;
                            }
                        }
                    } elseif ($g5 == "Iya") {
                        $m6F = "F";
                        $bobotm6F = 0.8;
                        $m6 = 0.2;

                        $m7F = ($bobotm6F * $m5F) + ($bobotm6F * $m5BF) + ($bobotm6F * $m5AF) + ($bobotm6F * $m5BDF) + ($bobotm6F * $m5) + ($m5F * $m6);
                        $m7AF = $m5AF * $m6;
                        $m7BDF = $m5BDF * $m6;
                        $m7BF = $m5BF * $m6;
                        $m7 = $m5 * $m6;

                        // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala, Bersin-Bersin dan Pilek atau Hidung Tersumbat
                        if ($m7F > $m7AF) {
                            if ($m7F > $m7BDF) {
                                if ($m7F > $m7BF) {
                                    $kategori = "Penyakit Flu";
                                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                    $hasil = $m7F * 100;
                                }
                            }
                        } elseif ($m7AF > $m7BDF) {
                            if ($m7AF > $m7BF) {
                                $kategori = "Penyakit Anemia, Flu";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                                $hasil = $m7AF * 100;
                            }
                        } elseif ($m7BDF > $m7BF) {
                            $kategori = "Penyakit Bronkitis, Demam, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BDF * 100;
                        } else {
                            $kategori = "Penyakit Bronkitis, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BF * 100;
                        }
                    }
                } elseif ($g4 == "Iya") {
                    $m4B = "B";
                    $bobotm4B = 0.4;
                    $m4 = 0.6;

                    $per = 1 - (($bobotm4B * $m3F) + ($bobotm4B * $m3AF));

                    $m5B = (($bobotm4B * $m3BDF) + ($bobotm4B * $m3)) / $per;
                    $m5F = ($m3F * $m4) / $per;
                    $m5BDF = ($m3BDF * $m4) / $per;
                    $m5AF = ($m3AF * $m4) / $per;
                    $m5 = ($m3 * $m4) / $per;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala dan Batuk
                    if ($m5B > $m5F) {
                        if ($m5B > $m5BDF) {
                            if ($m5B > $m5AF) {
                                $kategori = "Penyakit Bronkitis";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                $hasil = $m5B * 100;
                            }
                        }
                    } elseif ($m5F > $m5BDF) {
                        if ($m5F > $m5AF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5BDF > $m5AF) {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    } else {
                        $kategori = "Penyakit Anemia, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5AF * 100;
                    }
                } elseif ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $m5F = ($m3F * $bobotm4F) + ($m3AF * $bobotm4F)  + ($m3BDF * $bobotm4F) + ($m3 * $bobotm4F) + ($m3F * $m4);
                    $m5BDF = $m3BDF * $m4;
                    $m5AF = $m3AF * $m4;
                    $m5 = $m3 * $m4;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Sakit Kepala dan Pilek atau Hidung Tersumbat
                    if ($m5F > $m5BDF) {
                        if ($m5F > $m5AF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5BDF > $m5AF) {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    } else {
                        $kategori = "Penyakit Anemia, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5AF * 100;
                    }
                }
            } elseif ($g3 == "Iya") {
                $m2BF = "B,F";
                $bobotm2BF = 0.6;
                $bobotm2 = 0.4;

                $m3BDF = $bobotm1BDF * $bobotm2;
                $m3BF = ($bobotm1BDF * $bobotm2BF) + ($bobotm1 * $bobotm2BF);
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Badan Panas dan Bersin-Bersin
                if ($m3BDF > $m3BF) {
                    $kategori = "Penyakit Bronkitis, Demam, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BDF * 100;
                } else {
                    $kategori = "Penyakit Bronkitis, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BF * 100;
                }

                if ($g4 == "Iya") {
                    $m4B = "B";
                    $bobotm4B = 0.4;
                    $m4 = 0.6;

                    $m5B = (($bobotm4B * $m3BDF) + ($bobotm4B * $m3BF) + ($bobotm4B * $m3));
                    $m5BF = ($m3BF * $m4);
                    $m5BDF = ($m3BDF * $m4);
                    $m5 = $m3 * $m4;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Bersin-Bersin, dan Batuk
                    if ($m5B > $m5BF) {
                        if ($m5B > $m5BDF) {
                            $kategori = "Penyakit Bronkitis";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                            $hasil = $m5B * 100;
                        }
                    } elseif ($m5BF > $m5BDF) {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    }

                    if ($g5 == "Iya") {
                        $m6F = "F";
                        $bobotm6F = 0.8;
                        $m6 = 0.2;

                        $per = 1 - ($m5B * $bobotm6F);

                        $m7F = (($bobotm6F * $m5BF) + ($bobotm6F * $m5BDF) + ($bobotm6F * $m5)) / $per;
                        $m7B = ($m5B * $m6) / $per;
                        $m7BDF = ($m5BDF * $m6) / $per;
                        $m7BF = ($m5BF * $m6) / $per;
                        $m7 = ($m5 * $m6) / $per;

                        // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Bersin-Bersin, Batuk dan Pilek atau Hidung Tersumbat
                        if ($m7F > $m7B) {
                            if ($m7F > $m7BDF) {
                                if ($m7F > $m7BF) {
                                    $kategori = "Penyakit Flu";
                                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                    $hasil = $m7F * 100;
                                }
                            }
                        } elseif ($m7B > $m7BDF) {
                            if ($m7B > $m7BF) {
                                $kategori = "Penyakit Bronkitis";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                $hasil = $m7B * 100;
                            }
                        } elseif ($m7BDF > $m7BF) {
                            $kategori = "Penyakit Bronkitis, Demam, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BDF * 100;
                        } else {
                            $kategori = "Penyakit Bronkitis, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BF * 100;
                        }
                    }
                } elseif ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $m5F = (($bobotm4F * $m3BDF) + ($bobotm4F * $m3BF) + ($bobotm4F * $m3));
                    $m5BF = ($m3BF * $m4);
                    $m5BDF = ($m3BDF * $m4);
                    $m5 = $m3 * $m4;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Bersin-Bersin, dan Pilek atau Hidung Tersumbat
                    if ($m5F > $m5BF) {
                        if ($m5F > $m5BDF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5BF > $m5BDF) {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    }
                }
            } elseif ($g4 == "Iya") {
                $m2B = "B";
                $bobotm2B = 0.4;
                $bobotm2 = 0.6;

                $m3B = ($bobotm1BDF * $bobotm2B) + ($bobotm1 * $bobotm2B);
                $m3BDF = $bobotm1BDF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Badan Panas dan Batuk
                if ($m3B > $m3BDF) {
                    $kategori = "Penyakit Bronkitis";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                    $hasil = $m3B * 100;
                } else {
                    $kategori = "Penyakit Bronkitis, Demam, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BDF * 100;
                }

                if ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $per = 1 - ($m3B * $bobotm4F);

                    $m5B = ($m3B * $m4) / $per;
                    $m5F = (($m3BDF * $bobotm4F) + ($m3 * $bobotm4F)) / $per;
                    $m5BDF = ($m3BDF * $m4) / $per;
                    $m5 = ($m3 * $m4) / $per;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Batuk, dan Pilek atau Hidung Tersumbat
                    if ($m5B > $m5F) {
                        if ($m5B > $m5BDF) {
                            $kategori = "Penyakit Bronkitis";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                            $hasil = $m5B * 100;
                        }
                    } elseif ($m5F > $m5BDF) {
                        $kategori = "Penyakit Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5F * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Demam, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BDF * 100;
                    }
                }
            } elseif ($g5 == "Iya") {
                $m2F = "F";
                $bobotm2F = 0.8;
                $bobotm2 = 0.2;


                $m3F = ($bobotm1BDF * $bobotm2F) + ($bobotm1 * $bobotm2F);
                $m3BDF = $bobotm1BDF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Badan Panas dan Pilek atau Hidung Tersumbat
                if ($m3F > $m3BDF) {
                    $kategori = "Penyakit Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3F * 100;
                } else {
                    $kategori = "Penyakit Bronkitis, Demam, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Demam, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BDF * 100;
                }
            }
        } elseif ($g2 == "Iya") {
            $m1AF = "A,F";
            $bobotm1AF = 0.5;
            $bobotm1 = 0.5;

            // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala
            $kategori = "Penyakit Anemia, Flu";
            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
            $hasil = $bobotm1AF * 100;

            if ($g3 == "Iya") {
                $m2BF = "B,F";
                $bobotm2BF = 0.6;
                $bobotm2 = 0.4;

                $m3F = $bobotm1AF * $bobotm2BF;
                $m3BF = $bobotm1 * $bobotm2BF;
                $m3AF = $bobotm1AF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala dan Bersin-Bersin
                if ($m3F > $m3BF) {
                    if ($m3F > $m3AF) {
                        $kategori = "Penyakit Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m3BDF * 100;
                    }
                } elseif ($m3BF > $m3AF) {
                    $kategori = "Penyakit Bronkitis, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BF * 100;
                } else {
                    $kategori = "Penyakit Anemia, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3AF * 100;
                }

                if ($g4 == "Iya") {
                    $m4B = "B";
                    $bobotm4B = 0.4;
                    $m4 = 0.6;

                    $per = 1 - (($m3F * $bobotm4B) + ($m3AF * $bobotm4B));

                    $m5B = (($m3BF * $bobotm4B) + ($m3 * $bobotm4B)) / $per;
                    $m5F = ($m3F * $m4) / $per;
                    $m5AF = ($m3AF * $m4) / $per;
                    $m5BF = ($m3BF * $m4) / $per;
                    $m5 = ($m3 * $m4) / $per;

                    // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala, Bersin-Bersin dan Batuk
                    if ($m5B > $m5F) {
                        if ($m5B > $m5AF) {
                            if ($m5B > $m5BF) {
                                $kategori = "Penyakit Bronkitis";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                $hasil = $m5B * 100;
                            }
                        }
                    } elseif ($m5F > $m5AF) {
                        if ($m5F > $m5BF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5AF > $m5BF) {
                        $kategori = "Penyakit Anemia, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5AF * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    }

                    if ($g5 == "Iya") {
                        $m6F = "F";
                        $bobotm6F = 0.8;
                        $m6 = 0.2;

                        $per = 1 - ($m5B * $bobotm6F);

                        $m7F = (($bobotm6F * $m5F) + ($bobotm6F * $m5AF) + ($bobotm6F * $m5BF) + ($bobotm6F * $m5) + ($m6 * $m5F)) / $per;
                        $m7B = ($m5B * $m6) / $per;
                        $m7AF = ($m5AF * $m6) / $per;
                        $m7BF = ($m5BF * $m6) / $per;
                        $m7 = ($m5 * $m6) / $per;

                        // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala, Bersin-Bersin, Batuk dan Pilek atau Hidung Tersumbat
                        if ($m7F > $m7B) {
                            if ($m7F > $m7AF) {
                                if ($m7F > $m7BF) {
                                    $kategori = "Penyakit Flu";
                                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                                    $hasil = $m7F * 100;
                                }
                            }
                        } elseif ($m7B > $m7AF) {
                            if ($m7B > $m7BF) {
                                $kategori = "Penyakit Bronkitis";
                                $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                                $hasil = $m7B * 100;
                            }
                        } elseif ($m7AF > $m7BF) {
                            $kategori = "Penyakit Anemia, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7AF * 100;
                        } else {
                            $kategori = "Penyakit Bronkitis, Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m7BF * 100;
                        }
                    }
                } elseif ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $m5F = (($bobotm4F * $m3F) + ($bobotm4F * $m3BF) + ($bobotm4F * $m3AF) + ($bobotm4F * $m3) + ($m4 * $m3F));
                    $m5BF = ($m3BF * $m4);
                    $m5AF = ($m3AF * $m4);
                    $m5 = $m3 * $m4;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Bersin-Bersin, dan Pilek atau Hidung Tersumbat
                    if ($m5F > $m5BF) {
                        if ($m5F > $m5AF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5BF > $m5AF) {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    } else {
                        $kategori = "Penyakit Anemia, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5AF * 100;
                    }
                }
            } elseif ($g4 == "Iya") {
                $m2B = "B";
                $bobotm2B = 0.4;
                $bobotm2 = 0.6;

                $per = 1 - ($bobotm1AF * $bobotm2B);

                $m3B = ($bobotm1 * $bobotm2B) / $per;
                $m3AF = ($bobotm1AF * $bobotm2) / $per;
                $m3 = $bobotm1 * $bobotm2 / $per;

                // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala dan Batuk
                if ($m3B > $m3AF) {
                    $kategori = "Penyakit Bronkitis";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                    $hasil = $m3B * 100;
                } else {
                    $kategori = "Penyakit Anemia, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3AF * 100;
                }

                if ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $per = 1 - ($m3B * $bobotm4F);

                    $m5F = (($bobotm4F * $m3AF) + ($bobotm4F * $m3)) / $per;
                    $m5B = ($m3B * $m4) / $per;
                    $m5AF = ($m3AF * $m4) / $per;
                    $m5 = ($m3 * $m4) / $per;

                    // Hasil Diagnosa Jika Memilih Gejala Badan Panas, Batuk, dan Pilek atau Hidung Tersumbat
                    if ($m5F > $m5B) {
                        if ($m5F > $m5AF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5B > $m5AF) {
                        $kategori = "Penyakit Bronkitis";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                        $hasil = $m5B * 100;
                    } else {
                        $kategori = "Penyakit Anemia, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5AF * 100;
                    }
                }
            } elseif ($g5 == "Iya") {
                $m2F = "F";
                $bobotm2F = 0.8;
                $bobotm2 = 0.2;


                $m3F = ($bobotm1AF * $bobotm2F) + ($bobotm1 * $bobotm2F);
                $m3AF = $bobotm1AF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Sakit Kepala dan Pilek atau Hidung Tersumbat
                if ($m3F > $m3AF) {
                    $kategori = "Penyakit Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3F * 100;
                } else {
                    $kategori = "Penyakit Anemia, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Anemia, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3AF * 100;
                }
            }
        } elseif ($g3 == "Iya") {
            $m1BF = "B,F";
            $bobotm1BF = 0.6;
            $bobotm1 = 0.4;

            // Hasil Diagnosa Jika Memilih Gejala Bersin-Bersin
            $kategori = "Penyakit Bronkitis, Flu";
            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
            $hasil = $bobotm1BF * 100;

            if ($g4 == "Iya") {
                $m2B = "B";
                $bobotm2B = 0.4;
                $bobotm2 = 0.6;

                $m3B = ($bobotm1BF * $bobotm2B) + ($bobotm1 * $bobotm2B);
                $m3BF = $bobotm1BF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Bersin-Bersin dan Batuk
                if ($m3B > $m3BF) {
                    $kategori = "Penyakit Bronkitis";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                    $hasil = $m3B * 100;
                } else {
                    $kategori = "Penyakit Bronkitis, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BF * 100;
                }

                if ($g5 == "Iya") {
                    $m4F = "F";
                    $bobotm4F = 0.8;
                    $m4 = 0.2;

                    $per = 1 - ($m3B * $bobotm4F);

                    $m5F = (($bobotm4F * $m3BF) + ($bobotm4F * $m3)) / $per;
                    $m5B = ($m3B * $m4) / $per;
                    $m5BF = ($m3BF * $m4) / $per;
                    $m5 = ($m3 * $m4) / $per;

                    // Hasil Diagnosa Jika Memilih Gejala Bersin-Bersin, Batuk, dan Pilek atau Hidung Tersumbat
                    if ($m5F > $m5B) {
                        if ($m5F > $m5BF) {
                            $kategori = "Penyakit Flu";
                            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                            $hasil = $m5F * 100;
                        }
                    } elseif ($m5B > $m5BF) {
                        $kategori = "Penyakit Bronkitis";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                        $hasil = $m5B * 100;
                    } else {
                        $kategori = "Penyakit Bronkitis, Flu";
                        $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                        $hasil = $m5BF * 100;
                    }
                }
            } elseif ($g5 == "Iya") {
                $m2F = "F";
                $bobotm2F = 0.8;
                $bobotm2 = 0.2;

                $m3F = ($bobotm1BF * $bobotm2F) + ($bobotm1 * $bobotm2F);
                $m3BF = $bobotm1BF * $bobotm2;
                $m3 = $bobotm1 * $bobotm2;

                // Hasil Diagnosa Jika Memilih Gejala Bersin-Bersin dan Pilek atau Hidung Tersumbat
                if ($m3F > $m3BF) {
                    $kategori = "Penyakit Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3F * 100;
                } else {
                    $kategori = "Penyakit Bronkitis, Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis, Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3BF * 100;
                }
            }
        } elseif ($g4 == "Iya") {
            $m1B = "B";
            $bobotm1B = 0.4;
            $bobotm1 = 0.6;

            // Hasil Diagnosa Jika Memilih Gejala Batuk
            $kategori = "Penyakit Bronkitis";
            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
            $hasil = $bobotm1B * 100;

            if ($g5 == "Iya") {
                $m2F = "F";
                $bobotm2F = 0.8;
                $bobotm2 = 0.2;

                $per = 1 - ($bobotm1B * $bobotm2F);

                $m3F = ($bobotm1 * $bobotm2F) / $per;
                $m3B = ($bobotm1B * $bobotm2) / $per;
                $m3 = ($bobotm1 * $bobotm2) / $per;

                // Hasil Diagnosa Jika Memilih Gejala Batuk dan Pilek atau Hidung Tersumbat
                if ($m3F > $m3B) {
                    $kategori = "Penyakit Flu";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
                    $hasil = $m3F * 100;
                } else {
                    $kategori = "Penyakit Bronkitis";
                    $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Bronkitis dengan Tingkat Kemungkinan ";
                    $hasil = $m3B * 100;
                }
            }
        } elseif ($g5 == "Iya") {
            $m1F = "F";
            $bobotm1F = 0.8;
            $bobotm1 = 0.2;

            // Hasil Diagnosa Jika Memilih Gejala Pilek atau Hidung Tersumbat
            $kategori = "Penyakit Flu";
            $penyakit = "Berdasarkan Gejala yang telah Anda Pilih, Anda di Diagnosis Mengalami Flu dengan Tingkat Kemungkinan ";
            $hasil = $bobotm1F * 100;
        }
    }
    ?>

    <script>
        var hasil = document.getElementById("hasil");
        hasil.innerHTML = `<h3>
    <b><?php echo $ket; ?></b></h3>
    <p>
    <b><?php echo $kategori; ?></b>
    <br>
    <?php echo $penyakit; ?><?php echo $hasil; ?><?php echo $percent; ?>
    </p>`;
    </script>

</body>

</html>