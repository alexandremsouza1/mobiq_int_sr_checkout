<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('action'); // Inserção ou Atualização
            $table->text('data'); // Dados do registro afetado
            $table->timestamps();
        });

        // Criação da trigger após a inserção
        DB::unprepared('
            CREATE TRIGGER product_log_after_insert AFTER INSERT ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO product_log (product_id, action, data, created_at, updated_at)
                VALUES (NEW.id, "Inserção", JSON_OBJECT("suggestedQuantity", NEW.suggestedQuantity, "stock", NEW.stock, "charge", NEW.charge, "code", NEW.code, "weight", NEW.weight, "unitFactor", NEW.unitFactor, "productName", NEW.productName, "kit", NEW.kit, "material", NEW.material, "polarized", NEW.polarized, "unitPrice", NEW.unitPrice, "priceTable", NEW.priceTable, "orderType", NEW.orderType, "segment", NEW.segment, "brand", NEW.brand, "category", NEW.category, "packagingType", NEW.packagingType, "groupKonnect", NEW.groupKonnect, "deliveryType", NEW.deliveryType, "flavor", NEW.flavor), NOW(), NOW());
            END
        ');

        // Criação da trigger após a atualização
        DB::unprepared('
            CREATE TRIGGER product_log_after_update AFTER UPDATE ON products
            FOR EACH ROW
            BEGIN
                INSERT INTO product_log (product_id, action, data, created_at, updated_at)
                VALUES (NEW.id, "Atualização", JSON_OBJECT("suggestedQuantity", NEW.suggestedQuantity, "stock", NEW.stock, "charge", NEW.charge, "code", NEW.code, "weight", NEW.weight, "unitFactor", NEW.unitFactor, "productName", NEW.productName, "kit", NEW.kit, "material", NEW.material, "polarized", NEW.polarized, "unitPrice", NEW.unitPrice, "priceTable", NEW.priceTable, "orderType", NEW.orderType, "segment", NEW.segment, "brand", NEW.brand, "category", NEW.category, "packagingType", NEW.packagingType, "groupKonnect", NEW.groupKonnect, "deliveryType", NEW.deliveryType, "flavor", NEW.flavor), NOW(), NOW());
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
        Schema::dropIfExists('product_log');
    }
};
