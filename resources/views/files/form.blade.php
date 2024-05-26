<div class="file-upload-container">
    <h3>Upload file to selected category</h3>
    <form action="{{ route('files.upload', ['categoryId' => ':categoryId']) }}" method="POST">
        <input type="file" name="file-upload" id="file-upload">
        <button class="file-upload-btn">Upload</button>
    </form>
</div>

<script>
    const FILE_UPLOAD_URL = "{{ route('files.upload', ['categoryId' => ':categoryId']) }}";
</script>