export interface ProcessedFile {
    id: number;
    original_name: string;
    type: string;
    download_url: string;
    expires_at: string | null;
    is_archive?: boolean;
    file_count?: number;
    size?: string | number;
    is_available?: boolean;
}

export interface PageProps extends Record<string, any> {
    tool?: 'batch' | 'optimizer' | 'converter' | 'thumbnails';
    flash?: {
        success?: string;
        processed?: {
            isArchive: boolean;
            downloadUrl: string;
            files: {
                filename: string;
                url: string;
            }[];
        };
    };
    files?: ProcessedFile[];
}
