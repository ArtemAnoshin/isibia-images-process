export interface ProcessedFile {
    id: number
    originalName: string
    type: string
    downloadUrl: string
    expiresAt: string | null
}

export interface PageProps extends Record<string, any> {
    flash?: {
        success?: string
        processed?: {
            isArchive: boolean
            downloadUrl: string
            files: {
                filename: string
                url: string
            }[]
        }
    }
    files?: ProcessedFile[]
}
