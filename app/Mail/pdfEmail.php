<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class pdfEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $filePath;
    protected $bukti;
    protected $tahun;
    public function __construct($filePath, $bukti, $tahun)
    {
        $this->filePath = $filePath;
        $this->bukti = $bukti;
        $this->tahun = $tahun;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice '+ $this->bukti + '-' + $this->tahun,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'pdf.penjualan.templateEmailKanvas',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->filePath)
                ->as('Invoice '+ $this->bukti + '-' + $this->tahun+'.pdf')
                ->withMime("application/pdf"),
        ];
    }
}
