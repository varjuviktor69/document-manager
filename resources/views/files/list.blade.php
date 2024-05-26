@props(['files',])

<div class="file-container">
    @foreach ($files as $file)
        <div class="file-list">
            <div class="path-container">
                <span>{{ $file->path }}</span>
            </div>
            <div>
                <a href="{{ route('files.get', ['id' => $file->id, 'version' => $file->version]) }}">
                    {{ $file->name }}.{{  $file->extension }}
                </a>
            </div>
            <div class="version-select-container">
                <span>version:</span>
                <select>
                    @foreach (range(1, $file->version) as $version)
                        <option value="{{ $version }}" {{ $file->version === $version ? 'selected' : ''}}>{{ $version }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach
</div>