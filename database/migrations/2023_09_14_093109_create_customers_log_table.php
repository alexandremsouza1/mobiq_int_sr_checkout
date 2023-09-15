<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('action'); // Inserção ou Atualização
            $table->text('data'); // Dados do registro afetado
            $table->timestamps();
        });

        // Criação da trigger
        DB::unprepared('
            CREATE TRIGGER customers_log_after_insert AFTER INSERT ON customers
            FOR EACH ROW
            BEGIN
                INSERT INTO customers_log (customer_id, action, data, created_at, updated_at)
                VALUES (NEW.id, "Inserção", JSON_OBJECT("clientId", NEW.clientId, "info", NEW.info), NOW(), NOW());
            END
        ');

        DB::unprepared('
            CREATE TRIGGER customers_log_after_update AFTER UPDATE ON customers
            FOR EACH ROW
            BEGIN
                INSERT INTO customers_log (customer_id, action, data, created_at, updated_at)
                VALUES (NEW.id, "Atualização", JSON_OBJECT("clientId", NEW.clientId, "info", NEW.info), NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers_log');
    }
};
