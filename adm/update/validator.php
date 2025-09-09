<?php
function validateZipContents($zipPath)
{
	$allowedExtensions = ['php', 'html', 'css', 'js', 'json', 'lock', 'jpg', 'jpeg', 'png', 'gif', 'ttf', 'svg', 'xls', 'xlsx', 'mp4', 'mp3', 'sql','txt', 'htaccess', 'md'];
	$disallowedFiles = [];

	$zip = new ZipArchive;
	if ($zip->open($zipPath) === TRUE) {
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$entry = $zip->statIndex($i);
			$fileName = $entry['name'];
			// Abaikan direktori
			if (substr($fileName, -1) === '/') continue;

			$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			if (!in_array($ext, $allowedExtensions)) {
				$disallowedFiles[] = $fileName;
			}

			if (strpos($fileName, '../') !== false) {
				$disallowedFiles[] = $fileName;
			}

			if ($entry['encryption_method'] !== ZipArchive::EM_NONE) {
				return ['error' => 'ZIP berpassword atau terenkripsi', 'files' => [$fileName]];
			}
		}
		$zip->close();
	} else {
		return ['error' => 'ZIP gagal dibuka'];
	}

	if (count($disallowedFiles) > 0) {
		return ['error' => 'ZIP mengandung file yang tidak diperbolehkan', 'files' => $disallowedFiles];
	}

	return ['success' => true];
}
