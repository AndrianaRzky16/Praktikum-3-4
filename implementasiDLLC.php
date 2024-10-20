<?php

/**
 * Node untuk menyimpan log pengeluaran barang dalam Double Linked List Circular.
 */
class LogNode
{
    private $itemName; // Nama barang yang dikeluarkan
    private $quantity; // Jumlah barang yang dikeluarkan
    private $timestamp; // Waktu pengeluaran
    public $next; // Pointer ke node berikutnya
    public $prev; // Pointer ke node sebelumnya

    /**
     * Constructor untuk inisialisasi log pengeluaran barang.
     */
    public function __construct($itemName, $quantity, $timestamp)
    {
        $this->itemName = $itemName;
        $this->quantity = $quantity;
        $this->timestamp = $timestamp;
        $this->next = null;
        $this->prev = null;
    }

    // Getter untuk mendapatkan nama barang
    public function getItemName()
    {
        return $this->itemName;
    }

    // Getter untuk mendapatkan jumlah barang
    public function getQuantity()
    {
        return $this->quantity;
    }

    // Getter untuk mendapatkan waktu pengeluaran barang
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

/**
 * Circular Double Linked List untuk mencatat log pengeluaran barang.
 * Struktur ini memungkinkan traversal baik maju maupun mundur, dan bersifat melingkar.
 */
class CircularLogList
{
    private $head = null; // Node pertama dalam daftar log
    private $tail = null; // Node terakhir dalam daftar log

    /**
     * Menambahkan log pengeluaran barang ke dalam daftar.
     * Setiap log mencatat waktu saat barang dikeluarkan.
     */
    public function addLog($itemName, $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be greater than zero."); // Validasi kuantitas
        }

        $timestamp = date("Y-m-d H:i:s"); // Mencatat waktu pengeluaran
        $newLog = new LogNode($itemName, $quantity, $timestamp);

        if ($this->head === null) {
            // Jika daftar log kosong
            $this->head = $newLog;
            $this->tail = $newLog;
            $this->tail->next = $this->head;
            $this->head->prev = $this->tail;
        } else {
            // Menambahkan log di akhir daftar
            $this->tail->next = $newLog;
            $newLog->prev = $this->tail;
            $this->tail = $newLog;
            $this->tail->next = $this->head;
            $this->head->prev = $this->tail;
        }
    }

    /**
     * Menampilkan semua log pengeluaran barang.
     * Traversal dilakukan dari head hingga kembali ke head.
     */
    public function displayLogs()
    {
        if ($this->head === null) {
            return "No logs available.\n"; // Jika tidak ada log
        }

        $current = $this->head;
        $logOutput = "";

        do {
            // Loop melalui daftar log
            $logOutput .= "Item: " . $current->getItemName() . ", Quantity: " . $current->getQuantity() . ", Time: " . $current->getTimestamp() . "\n";
            $current = $current->next;
        } while ($current !== $this->head);

        return $logOutput;
    }
}

// Contoh penggunaan CircularLogList
try {
    $logList = new CircularLogList();


    // Menambahkan beberapa log pengeluaran barang
    echo "=== Menambahkan Log Pengeluaran Barang ===\n";
    $logList->addLog("Laptop", 2);
    echo "Log pengeluaran 'Laptop' sebanyak 2 unit telah ditambahkan.\n";

    $logList->addLog("Printer", 1);
    echo "Log pengeluaran 'Printer' sebanyak 1 unit telah ditambahkan.\n";

    $logList->addLog("Scanner", 1);
    echo "Log pengeluaran 'Scanner' sebanyak 1 unit telah ditambahkan.\n";

    // Tampilkan log pengeluaran
    echo "\n=== Daftar Log Pengeluaran Barang ===\n";
    echo $logList->displayLogs();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
