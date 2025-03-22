@extends('layouts.template')
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ asset('./assets/dashboard/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('./assets/css/generate.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
@section('add-css')
    <style>
        #skipInfo {
            margin-left: 8px;
            vertical-align: middle;
        }

        .text-wrap {
            white-space: normal;
            word-wrap: break-word;
            min-width: 200px;
        }

        .dataTables_filter {
            float: right;
            text-align: right;
            margin-right: 10px;
        }
    </style>
@endsection
@section('info-page')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">generate</li>
    </ol>
    <h5 class="font-weight-bolder mb-0 text-capitalize">generate</h5>
@endsection

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-6 order-md-1 order-2">
                    <button class="btn btn-primary w-100" id="generate">Generate Question</button>
                </div>
                <div class="col-md-6 order-md-2 order-1">
                    <p class="text-start">Silakan tekan tombol "Generate Question" untuk membuat pertanyaan baru. Anda dapat
                        memilih bahasa, kursus, dan topik yang sesuai untuk pertanyaan yang ingin Anda buat.</p>
                </div>
            </div>
        </div>
        <div id="loading" style="display: none;">
            <div class="loader"></div>
            <div>Loading... <span id="progressPercentage">0%</span></div>
        </div>
        <div id="loadingScreen" style="display: none;">
            <div id="loadingMessage">Generating Questions...</div>
            <div id="progressBarContainer"
                style="background: #e0e0e0; border-radius: 5px; overflow: hidden; width: 100%; height: 25px;">
                <div id="progressBar" style="background: #007bff; width: 0%; height: 100%; transition: width 0.4s;"></div>
            </div>
            <div style="text-align: center; margin-top: 10px;">
                <span id="progressPercentage">0%</span>
            </div>
        </div>
        <!-- Tambahkan Tombol "Delete Selected" di atas DataTable -->
        <div class="container-xxl flex-grow-1 container-p-y" id="table-container" style="display: none;">
            <div class="d-flex mb-3">
                <button type="button" class="btn btn-success me-2" id="saveQuestions">Save Questions</button>
                <!-- Bulk Update Button -->
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                    data-bs-target="#updateBulkModal">
                    Update Selected
                </button>

                <!-- Delete Selected Button -->
                <button type="button" class="btn btn-danger" id="deleteSelectedRows">Delete Selected</button>
            </div>

            <!-- DataTable with Buttons -->
            <div class="card" id="card-block">
                <div class="card-datatable table-responsive pt-0">
                    <table class="table" id="table-data">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"></th>
                                <th>No</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Category</th>
                                <th>Page</th>
                                <th>Noun</th>
                                <th>Cosine Similarity</th>
                                <th>Threshold</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


        <!-- Modal Structure for Generate Question -->
        <div class="modal fade" id="generateQuestionModal" tabindex="-1" aria-labelledby="generateQuestionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="generateQuestionModalLabel">Generate Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="generateQuestionForm">
                            <!-- Pilihan Kursus -->
                            <div class="mb-3">
                                <label for="courseInput" class="form-label">Course</label>
                                <select class="form-select" id="courseInput" required>
                                    <option value="" selected>Choose Course</option>
                                </select>
                            </div>

                            <!-- Pilihan Topik -->
                            <div class="mb-3" id="topic">
                                <label for="topicInput" class="form-label">Topic</label>
                                <select class="form-select" id="topicInput" required>
                                    <option value="" selected>Choose Topic</option>
                                </select>
                                <div id="filePathDisplay" style="display: flex; align-items: center;">
                                    <span id="filePath" style="cursor: pointer;"></span>
                                    <button type="button" class="btn btn-danger mt-2" id="deleteFilePath"
                                        style="margin-left: 10px;">Delete File</button>
                                </div>
                                <div class="mb-3" id="pdfUpload" style="display: none;">
                                    <label for="pdfInput" class="form-label">Upload PDF</label>
                                    <input type="file" class="form-control" id="pdfInput" name="pdfInput"
                                        accept=".pdf">
                                </div>
                            </div>

                            <!-- Pilihan Bahasa File -->
                            <div class="mb-3" id="fileLanguageContainer" style="display: none;">
                                <label for="fileLanguage" class="form-label">File Language</label>
                                <select class="form-select" id="fileLanguage" required>
                                    <option value="english" selected>English</option>
                                    <option value="indonesia">Indonesia</option>
                                    <option value="japanese">Japanese</option>
                                </select>
                            </div>

                            <!-- Pilihan Bahasa Pertanyaan -->
                            <div class="mb-3">
                                <label for="languageCheckboxGroup" class="form-label">Select Languages</label>
                                <div id="languageCheckboxGroup">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="english"
                                            id="languageEnglish" name="languages[]">
                                        <label class="form-check-label" for="languageEnglish">English</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="indonesia"
                                            id="languageIndonesia" name="languages[]">
                                        <label class="form-check-label" for="languageIndonesia">Indonesia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="japanese"
                                            id="languageJapanese" name="languages[]">
                                        <label class="form-check-label" for="languageJapanese">Japanese</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Kata Benda -->
                            {{-- <div class="mb-3" id="nounInput">
                                <label for="questionInput" class="form-label">Noun with ","</label>
                                <input type="text" class="form-control" id="questionInput" name="questionInput">
                            </div> --}}

                            <!-- Skip Pages -->
                            {{-- <div class="d-flex align-items-center" id="skipButton" style="display: none;">
                                <div class="form-check" id="skipButton">
                                    <input type="checkbox" class="form-check-input" id="skipPagesCheckbox">
                                    <label class="mt-1 form-check-label" for="skipPagesCheckbox">Skip Unprocessable
                                        Pages</label>
                                </div>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Structure for Bulk Update -->
        <div class="modal fade" id="updateBulkModal" tabindex="-1" aria-labelledby="updateBulkModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateBulkModalLabel">Update Selected Rows</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulkThreshold" class="form-label">Threshold</label>
                            <input type="number" id="bulkThreshold" class="form-control" placeholder="Enter Threshold"
                                min="0" max="100">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="updateSelectedRows" class="btn btn-primary">Update Selected</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('vendor-javascript')
    <script src="{{ asset('./assets/dashboard/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-responsive/datatables.responsive.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/datatables-buttons.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.html5.js') }}"></script>
    <script src="{{ asset('./assets/dashboard/datatables-buttons/buttons.print.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection

@section('custom-javascript')
    <script>
        $(document).ready(function() {
            $('#table-container').hide();
            $('#topic').hide();
            $('#filePathDisplay').hide();
            $('#deleteFilePath').hide();

            // Fungsi untuk handle submit form
            let completedRequests = 0; // Jumlah operasi yang sudah selesai
            let totalRequests = 0; // Total operasi yang akan dijalankan
            let errorMessages = [];

            $('#generateQuestionForm').submit(function(event) {
                event.preventDefault();
                $('#table-container').hide();
                $('#generateQuestionModal').modal('hide');

                const pdfFile = $('#pdfInput')[0].files[0];
                const topic = $('#topicInput').val();

                // Reset counter sebelum memulai loop baru
                completedRequests = 0;
                totalRequests = 0;

                // Ambil bahasa yang dipilih untuk translate
                const selectedLanguages = [];
                $('#languageCheckboxGroup input:checked').each(function() {
                    selectedLanguages.push($(this).val());
                });

                if (selectedLanguages.length === 0) {
                    toastr.options.closeButton = true;
                    toastr.options.timeOut = 3000;
                    toastr.error('Please select at least one language for translation.');
                    return;
                }

                // Set jumlah total operasi berdasarkan bahasa yang dipilih
                totalRequests = selectedLanguages.length;
                startProcess();
                if (cachedFilePath) {
                    // Jika menggunakan file yang sudah dicache
                    selectedLanguages.forEach(language => {
                        sendToTranslateDocument(language, topic);
                    });
                } else if (pdfFile) {
                    // Jika ada file PDF yang diupload
                    uploadFile(pdfFile, $('#fileLanguage').val(), topic, selectedLanguages);
                } else {
                    toastr.options.closeButton = true;
                    toastr.options.timeOut = 3000;
                    toastr.error('Please upload a PDF file or select a topic with an existing file.');
                }
            });

            $('#saveQuestions').on('click', function() {
                const table = $('#table-data').DataTable();
                const questionsData = table.rows().data().toArray();
                const topicGuid = $('#topicInput').val();
                const code = $('#courseInput').val(); // Ambil nilai code dari dropdown kursus

                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question/save",
                    data: {
                        topic_guid: topicGuid,
                        questions: questionsData
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.success("Questions saved successfully.");

                        // Redirect ke route question setelah sukses
                        window.location.href = "{{ url('/question') }}/" + code + "/" +
                            topicGuid;
                    },
                    error: function(xhr) {
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.error("Failed to save questions: " + xhr.responseText);
                    }
                });
            });

            function uploadFile(file, fileLanguage, topic, languages) {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('language', fileLanguage); // Kirimkan bahasa yang dipilih untuk file
                formData.append('topic_guid', topic);


                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/topic/upload-file",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function() {
                        // $.unblockUI();
                        // alert('File uploaded successfully.');
                        updateProcessStatus('Upload File', fileLanguage, true);

                        // Lakukan translate untuk setiap bahasa setelah upload berhasil
                        languages.forEach(language => {
                            sendToTranslateDocument(language, topic);
                        });
                    },
                    error: function() {
                        $.unblockUI();
                        updateProcessStatus('Upload File', fileLanguage, false);
                        toastr.options.closeButton = true;
                        toastr.options.timeOut = 3000;
                        toastr.error('Failed to upload file.');
                    }

                });
            }

            function updateProcessStatus(step, language, isSuccess) {
                const stepContainer = $('#process-status-list');
                let icon = isSuccess ? '✔️' : '❌'; // Pilih ikon sesuai status
                let color = isSuccess ? 'green' : 'red'; // Pilih warna teks

                // Jika elemen belum ada, tambahkan ke dalam daftar
                let stepItem = stepContainer.find(`#step-${step}-${language}`);
                if (stepItem.length === 0) {
                    stepContainer.append(`
            <li id="step-${step}-${language}" style="color: ${color}; font-weight: bold;">
                ${icon} ${step} for ${language}
            </li>
        `);
                }
            }


            function startProcess() {
                $.blockUI({
                    message: `
        <div style="text-align: left; font-size: 16px; font-family: Arial, sans-serif;">
            <h4>Processing Steps:</h4>
            <ul id="process-status-list">
                <li>Initializing...</li>
            </ul>
        </div>`,
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#f4f4f4',
                        opacity: 0.9,
                        color: '#333',
                        fontSize: '18px',
                        borderRadius: '8px',
                        width: '400px',
                        minWidth: '300px'
                    },
                    overlayCSS: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        opacity: 0.8
                    }
                });
            }

            function sendToTranslateDocument(language, topic) {
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question/translate",
                    data: {
                        'language': language,
                        'topic_guid': topic
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function() {
                        updateProcessStatus('Translating Document', language, true); // ✅ Sukses
                        sendToTfidfDocument(language, topic);
                    },
                    error: function(xhr) {
                        updateProcessStatus('Translating Document', language, false);

                        let errorMessage =
                            `Translation failed for ${language}: ${xhr.responseJSON?.message || "Unknown error"}`;
                        errorMessages.push(errorMessage);
                        checkCompletion();
                    }

                });
            }

            function sendToTfidfDocument(language, topic) {
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question/tfidf",
                    data: {
                        'language': language,
                        'topic_guid': topic
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function() {
                        updateProcessStatus('Calculating TF-IDF', language, true); // ✅ Sukses
                        sendToGenerateData(language, topic);
                    },
                    error: function(xhr) {
                        updateProcessStatus('Calculating TF-IDF', language, false); // ❌ Gagal
                        let errorMessage =
                            `TF-IDF failed for ${language}: ${xhr.responseJSON?.message || "Unknown error"}`;
                        errorMessages.push(errorMessage);
                        checkCompletion();
                    }
                });
            }

            function sendToGenerateData(language, topic) {
                $.ajax({
                    type: "POST",
                    url: "{{ env('URL_API') }}/api/v1/question/generate",
                    data: {
                        'language': language,
                        'topic_guid': topic
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                    },
                    success: function(response) {
                        updateProcessStatus('Generating Questions', language, true); // ✅ Sukses
                        loadDataToTable(response.data, language);
                        checkCompletion();
                    },
                    error: function() {
                        updateProcessStatus('Generating Questions', language, false); // ❌ Gagal
                        let errorMessage =
                            `Generation failed for ${language}: ${xhr.responseJSON?.message || "Unknown error"}`;
                        errorMessages.push(errorMessage);
                        checkCompletion();
                    }
                });
            }

            // Fungsi untuk mengecek apakah semua permintaan selesai
            function checkCompletion() {
                completedRequests++;

                if (completedRequests === totalRequests) {
                    $.unblockUI();

                    // Jika ada yang sukses, tampilkan pesan sukses
                    if (errorMessages.length < totalRequests) {
                        toastr.success("All possible steps completed successfully!");
                    }

                    // Jika ada error, tampilkan semua pesan error
                    if (errorMessages.length > 0) {
                        errorMessages.forEach(msg => {
                            toastr.options = {
                                "closeButton": true, // Tambahkan tombol close (X)
                                "timeOut": 0, // Tidak ada auto-hide
                                "extendedTimeOut": 0, // Tidak hilang meskipun mouse keluar
                            };
                            toastr.error(msg);
                        });
                    }

                    // Reset error messages dan failedLanguages untuk proses selanjutnya
                    errorMessages = [];
                }
            }




            let lastIndex = 0; // Variabel untuk menyimpan nomor terakhir

            function loadDataToTable(data, language) {
                // Tambahkan bahasa ke setiap data
                data.forEach((item, i) => {
                    item.index = lastIndex + i + 1; // Gunakan lastIndex untuk penomoran
                    item.language = language; // Tambahkan kolom bahasa
                    item.checkbox = ''; // Checkbox untuk setiap baris
                    item.threshold = item.threshold || 0;
                    item.weight = item.weight || 0;
                });

                // Jika tabel belum ada, buat tabel baru
                if (!$.fn.DataTable.isDataTable('#table-data')) {
                    $('#table-container').show(); // Tampilkan container tabel
                    $('#table-data').DataTable({
                        data: data,
                        columns: [{
                                data: 'checkbox',
                                title: '<input type="checkbox" id="checkAll">',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<input type="checkbox" class="row-checkbox" data-id="${row.guid}" ${data ? 'checked' : ''}>`;
                                }
                            },
                            {
                                data: 'index',
                                title: 'No'
                            },
                            {
                                data: 'language',
                                title: 'Language'
                            },
                            {
                                data: 'question',
                                title: 'Question',
                                className: 'text-wrap'
                            },
                            {
                                data: 'answer',
                                title: 'Answer',
                                className: 'text-wrap'
                            },
                            {
                                data: 'category',
                                title: 'Category'
                            },
                            {
                                data: 'page_number',
                                title: 'Page'
                            },
                            {
                                data: 'cosine_q&d',
                                title: 'Cosine Similarity'
                            },
                            {
                                data: 'threshold',
                                title: 'Threshold',
                                render: function(data) {
                                    return `<input type="number" class="form-control threshold-input" value="${data || 0}" min="0" max="100">`;
                                }
                            },
                        ],
                        destroy: true,
                        scrollX: true,
                    });

                    $('#checkAll').on('click', function() {
                        const isChecked = $(this).is(':checked');
                        const table = $('#table-data').DataTable();

                        // Update semua data di DataTable (termasuk yang tidak terlihat di halaman saat ini)
                        table.rows().every(function() {
                            const data = this.data();
                            data.checkbox = isChecked; // Update status checkbox di data
                            this.data(data); // Simpan perubahan ke DataTable
                        });

                        // Perbarui tampilan UI untuk halaman saat ini
                        table.rows({
                            search: 'applied'
                        }).nodes().each(function(row) {
                            $(row).find('.row-checkbox').prop('checked', isChecked);
                        });
                    });

                } else {
                    // Tambahkan data ke tabel yang sudah ada
                    const table = $('#table-data').DataTable();
                    table.rows.add(data).draw(); // Tambahkan baris baru dan perbarui tampilan tabel
                }

                // Update lastIndex untuk penomoran berikutnya
                lastIndex += data.length; // Tambahkan jumlah data baru ke lastIndex
            }

            $('#table-data').on('change', '.row-checkbox', function() {
                const table = $('#table-data').DataTable();
                const row = $(this).closest('tr');
                const rowIndex = table.row(row).index();
                const data = table.row(rowIndex).data();

                // Perbarui state checkbox di data
                data.checkbox = $(this).is(':checked');
                table.row(rowIndex).data(data);

                // Perbarui status checkbox global
                const allCheckboxes = table.rows({
                    search: 'applied'
                }).data().toArray();
                const allChecked = allCheckboxes.every(row => row.checkbox);

                $('#checkAll').prop('checked', allChecked);
            });


            // Event listener untuk tombol update di dalam modal
            // Event listener untuk tombol update di dalam modal
            $('#updateSelectedRows').on('click', function() {
                const bulkThreshold = $('#bulkThreshold').val();

                if (bulkThreshold === '') {
                    toastr.options.closeButton = true;
                    toastr.options.timeOut = 3000;
                    toastr.error('Please enter a value for threshold.');
                    return;
                }

                const table = $('#table-data').DataTable();

                // Iterasi melalui semua data di DataTable
                table.rows().every(function() {
                    const data = this.data();
                    // Periksa apakah baris ini dicentang
                    if (data.checkbox) {
                        data.threshold = bulkThreshold; // Update nilai threshold
                        this.data(data); // Simpan perubahan ke DataTable
                    }
                });

                // Redraw tabel untuk memperbarui tampilan
                table.draw(false);

                $('#updateBulkModal').modal('hide');
                toastr.options.closeButton = true;
                toastr.options.timeOut = 3000;
                toastr.success('Selected rows updated successfully.');
            });


            $('#deleteSelectedRows').on('click', function() {
                const table = $('#table-data').DataTable();

                // Ambil semua checkbox yang dicentang
                const selectedRows = $('.row-checkbox:checked');

                if (selectedRows.length === 0) {
                    toastr.options.closeButton = true;
                    toastr.options.timeOut = 3000;
                    toastr.error('No rows selected.');
                    return;
                }

                if (!confirm('Are you sure you want to delete the selected rows?')) {
                    return;
                }

                // Loop melalui setiap checkbox yang dipilih dan hapus baris dari DataTable
                selectedRows.each(function() {
                    const row = $(this).closest('tr'); // Temukan baris terkait checkbox
                    table.row(row).remove().draw(
                        false); // Hapus baris dari DataTable tanpa submit ke backend
                });

                // Update nomor urut setelah penghapusan
                updateRowNumbers(table);

                toastr.options.closeButton = true;
                toastr.options.timeOut = 3000;
                toastr.success('Selected rows deleted successfully.');
            });

            // Fungsi untuk memperbarui nomor urut setelah penghapusan
            function updateRowNumbers(table) {
                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    const data = this.data();
                    data.index = rowIdx + 1; // Update nomor urut berdasarkan posisi baris
                    this.data(data); // Update data di DataTable
                });
                table.draw(false); // Redraw tabel untuk menampilkan nomor urut yang diperbarui
            }


            $('#generate').click(function() {
                $('#generateQuestionModal').modal('show');
            });

            $('#questionInput').on('input', function() {
                if ($(this).val() !== '') {
                    $('#pdfUpload').hide();
                    // $('#skipButton').hide();
                } else {
                    $('#pdfUpload').show();
                    // $('#skipButton').show();
                }
            });

            $('#pdfInput').on('change', function() {
                if ($(this).prop('files').length > 0) {
                    // $('#nounInput').hide();
                    // $('#skipButton').show();
                } else {
                    // $('#nounInput').show();
                }
            });

            $('#skipInfo').tooltip();

            $.ajax({
                type: "GET",
                url: "{{ env('URL_API') }}/api/v1/user-course/user/{{ $id }}",
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", "Bearer {{ $token }}");
                },
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(element => {
                            $('#courseInput').append(
                                $("<option />").val(element.code).text(element.code + '-' +
                                    element.name)
                            );
                        });
                    } else {
                        console.log("No courses available.");
                    }
                },
                error: function(xhr) {
                    // Display error message using toastr
                    toastr.options.closeButton = true;
                    toastr.error("Error loading courses: " + xhr.responseText, "Error");
                }
            });

            $('#courseInput').on('change', function() {
                const course = $('#courseInput').val();
                $('#pdfUpload').hide();
                $('#filePathDisplay').hide();
                $('#fileLanguageContainer').hide();
                if (course) {
                    $('#topic').show();

                    $.ajax({
                        type: "POST",
                        url: "{{ env('URL_API') }}/api/v1/topic/filter/course",
                        data: {
                            'code': course
                        },
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        success: function(response) {
                            $('#topicInput').empty().append(
                                '<option value="" selected>Choose Topic</option>');
                            response.data.forEach(element => {
                                $('#topicInput').append($("<option />").val(element
                                    .guid).text(element.name));
                            });
                        },
                        error: function(xhr) {
                            // Display error message using toastr
                            toastr.options.closeButton = true;
                            toastr.error("Error loading topics: " + xhr.responseText, "Error");

                            // Log error to console for debugging purposes
                            console.error("Error loading topics:", xhr.responseText);
                        }
                    });
                } else {
                    $('#topic').hide();
                }
            });

            let cachedFilePath = null;
            $('#topicInput').on('change', function() {
                const topic = $(this).val();
                if (topic) {
                    $.ajax({
                        type: "GET",
                        url: "{{ env('URL_API') }}/api/v1/topic/" + topic,
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization",
                                "Bearer {{ $token }}");
                        },
                        success: function(response) {
                            cachedFilePath = response['data']['file_path'];
                            const fileName = cachedFilePath ? cachedFilePath.split('/').pop()
                                .replace(/^\w+_/, '') : '';

                            if (cachedFilePath) {
                                $('#filePath').html(
                                    `<a href="{{ env('URL_API') }}/storage/${cachedFilePath}" target="_blank">${fileName}</a>`
                                );
                                $('#filePathDisplay').show();
                                $('#deleteFilePath').show();
                                $('#pdfUpload').hide();
                                // $('#nounInput').hide();
                                // $('#skipButton').show();
                                $('#fileLanguageContainer')
                                    .hide(); // Hide "File Language" if file exists
                            } else {
                                $('#filePathDisplay').hide();
                                $('#deleteFilePath').hide();
                                $('#pdfUpload').show();
                                // $('#nounInput').show();
                                $('#fileLanguageContainer')
                                    .show(); // Show "File Language" if no file
                            }
                        },
                        error: function(xhr) {
                            // Display error message using toastr
                            toastr.options.closeButton = true;
                            toastr.error("Error checking topic file path: " + xhr.responseText,
                                "Error");

                            // Log error to console for debugging purposes
                            console.error("Error checking topic file path:", xhr.responseText);
                        }
                    });
                } else {
                    cachedFilePath = null;
                    $('#filePathDisplay').hide();
                    $('#deleteFilePath').hide();
                    $('#pdfUpload').hide();
                    // $('#nounInput').show();
                    $('#fileLanguageContainer').show(); // Show "File Language" if no topic selected
                }
            });


            $('#deleteFilePath').click(function() {
                const topicGuid = $('#topicInput').val();
                $.ajax({
                    url: "{{ env('URL_API') }}/api/v1/topic/delete-file",
                    type: "POST",
                    data: {
                        topic_guid: topicGuid
                    },
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization",
                            "Bearer {{ $token }}");
                    },
                    success: function() {
                        $('#filePathDisplay').hide();
                        $('#deleteFilePath').hide();
                        $('#pdfUpload').show();
                        $('#fileLanguageContainer').show();
                        cachedFilePath = null;

                        // Display success message using toastr
                        toastr.options.closeButton = true;
                        toastr.success("File has been successfully deleted", "Success");
                    },

                    error: function(xhr) {
                        // Display error message using toastr
                        toastr.options.closeButton = true;
                        toastr.error("Failed to delete file: " + xhr.statusText, "Error");
                    }

                });
            });
        });
    </script>
@endsection
