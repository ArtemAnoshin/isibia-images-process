export interface ProcessedFile {
    id: number;
    original_name: string;
    type: string;
    download_url: string;
    created_at: string;
    size?: string | number;
}

export interface PageProps extends Record<string, any> {
    tool?: 'batch' | 'optimizer' | 'converter' | 'thumbnails';
    flash?: {
        success?: string;
        processed?: {
            isArchive: boolean;
            downloadUrl: string;
            originalSize: number;
            processedSize: number;
            downloadSize: number;
            fileCount: number;
            files: {
                filename: string;
                url: string;
                size: number;
            }[];
        };
    };
    files?: ProcessedFile[];
}
