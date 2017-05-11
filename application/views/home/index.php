<!-- Begin page content -->
<div class="container">

    <div class="page-header">
        <h1>Card reader</h1>
    </div>

    <div class="row">

        <div class="col-md-7">

            <!-- Form element -->
            <form method="post" enctype="multipart/form-data">

                <div class="form-group">

                    <label for="">File input ( gif, jpg, png) </label>
                    <input type="file"  id="hin_file" name="hin_file" />

                </div>
                <button type="submit" class="btn btn-default">Submit</button>

            </form>

            <!-- Progress bar -->
            <div class="wrap_uploading_progress clearfix" style="display:none; margin-top:15px;">

                <p class="text-primary" id="txt_upload_message">Uploading files</p>
                <div class="progress">

                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                        0%
                    </div>

                </div>

            </div>

            <img src="" id="sample_image" style="width: 100%; display: none" />

        </div>

        <!-- Result -->
        <div class="col-md-5">

            <h4>Result</h4>
            <p></p>

        </div>

    </div>

</div>