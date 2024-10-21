<?php

/**
 * Node untuk menyimpan informasi barang dalam Single Linked List Circular.
 */
class ItemNode
{
    private $itemName; // Nama barang
    public $quantity; // Jumlah barang
    public $next; // Pointer ke node berikutnya

    /**
     * Constructor untuk inisialisasi nama dan jumlah barang.
     */
    public function __construct($itemName, $quantity)
    {
        $this->itemName = $itemName;
        $this->quantity = $quantity;
        $this->next = null; // Inisialisasi pointer berikutnya dengan null
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
}

/**
 * Circular Linked List untuk manajemen barang dalam gudang.
 * Struktur ini memungkinkan traversal melalui node secara melingkar.
 */
class CircularItemList
{
    private $head = null; // Node pertama dalam daftar
    private $tail = null; // Node terakhir dalam daftar

    /**
     * Menambahkan barang baru ke dalam daftar.
     * Jika daftar kosong, node baru menjadi head dan tail, dan mereka menunjuk satu sama lain.
     * Jika tidak, node baru ditambahkan di akhir dan tail akan menunjuk ke head.
     */
    public function addItem($itemName, $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be greater than zero."); // Validasi kuantitas
        }

        $newItem = new ItemNode($itemName, $quantity);

        if ($this->head === null) {
            // Jika daftar kosong, head dan tail diatur ke item baru
            $this->head = $newItem;
            $this->tail = $newItem;
            $this->tail->next = $this->head; // Membuat daftar menjadi circular
        } else {
            // Menambahkan item di akhir daftar
            $this->tail->next = $newItem;
            $this->tail = $newItem;
            $this->tail->next = $this->head; // Menjaga daftar tetap circular
        }
    }

    /**
     * Menampilkan semua barang di dalam gudang.
     * Traversal dilakukan dari head hingga kembali ke head (sistem circular).
     */
    public function displayItems()
    {
        if ($this->head === null) {
            return "No items available.\n"; // Jika daftar kosong, tampilkan pesan
        }

        $current = $this->head;
        $itemsOutput = "";

        do {
            // Loop melalui daftar sampai kembali ke head
            $itemsOutput .= "Item: " . $current->getItemName() . ", Quantity: " . $current->getQuantity() . "\n";
            $current = $current->next;
        } while ($current !== $this->head);

        return $itemsOutput;
    }

    /**
     * Mengeluarkan barang dari gudang dengan mengurangi jumlahnya.
     * Jika kuantitas yang tersedia tidak mencukupi, akan menampilkan error.
     */
    public function removeItem($itemName, $quantity)
    {
        if ($this->head === null) {
            throw new Exception("No items in the warehouse.");
        }

        $current = $this->head;

        do {
            // Cari item yang ingin dikeluarkan
            if ($current->getItemName() === $itemName) {
                if ($current->getQuantity() < $quantity) {
                    throw new Exception("Not enough quantity available."); // Validasi jumlah barang
                } else {
                    $current->quantity -= $quantity; // Kurangi kuantitas barang
                    return true;
                }
            }
            $current = $current->next;
        } while ($current !== $this->head);

        throw new Exception("Item not found.");
    }
}

// Contoh penggunaan CircularItemList
try {
    $itemList = new CircularItemList();

    echo "=== Kelompok 4 Struktur Data dan Algoritma ===\n";
    echo "231232004 Muhammad Iqbal Ramadhan \n";
    echo "231232008 Andriana Rizki B \n";
    echo "231132001 Kayla Nindya Putri Maulana \n";
    echo "231132003 Alika Putri Widayani \n";
    echo "231232006 Sutan Ihsan \n";
    echo "231232029 Aldi Alamsyah \n";
    echo "⁠231232015 Harpan Pudoli Mukti \n";
    echo "=============================================\n \n";

    // Tambahkan beberapa barang ke dalam daftar
    echo "=== Menambahkan Barang ke Dalam Gudang ===\n";
    $itemList->addItem("Laptop", 10);
    echo "Barang 'Laptop' dengan kuantitas 10 telah ditambahkan.\n";

    $itemList->addItem("Printer", 5);
    echo "Barang 'Printer' dengan kuantitas 5 telah ditambahkan.\n";

    $itemList->addItem("Scanner", 3);
    echo "Barang 'Scanner' dengan kuantitas 3 telah ditambahkan.\n";

    // Tampilkan barang yang tersedia di gudang
    echo "\n=== Daftar Barang yang Tersedia di Gudang ===\n";
    echo $itemList->displayItems();

    // Mengeluarkan barang dari gudang
    echo "\n=== Mengeluarkan Barang dari Gudang ===\n";
    $itemList->removeItem("Laptop", 2);
    echo "Barang 'Laptop' sebanyak 2 unit telah dikeluarkan.\n";

    // Tampilkan barang setelah pengurangan
    echo "\n=== Daftar Barang Setelah Pengurangan ===\n";
    echo $itemList->displayItems();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
