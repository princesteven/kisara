<?php

namespace App\Services\MongoDB;

use Modules\Services\Entities\Document;

class DocumentService
{
    /**
     * Save document in MongoDB
     *
     * @param array $file
     * @return mixed
     */
    public function save(array $file): mixed
    {
        return Document::updateOrCreate(['file' => $file['file']]);
    }

    /**
     * Retrieve document from MongoDB
     *
     * @param string $documentId
     * @return mixed
     */
    public function retrieve(string $documentId): mixed
    {
        return Document::find($documentId);
    }

    /**
     * Delete document from MongoDB
     *
     * @param string $documentId
     * @return mixed
     */
    public function destroy(string $documentId): mixed
    {
        $document = Document::find($documentId);

        return $document->delete();
    }
}
