<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
  
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->date('data_nasc')->nullable();
        $table->decimal('peso', 5, 2)->nullable();
        $table->decimal('altura', 4, 2)->nullable();
        $table->string('tipo_sanguineo', 5)->nullable();
        $table->string('cep', 9)->nullable();
        $table->string('logradouro')->nullable();
        $table->string('complemento')->nullable();
        $table->string('bairro')->nullable();
        $table->string('cidade')->nullable();
        $table->string('estado')->nullable();
       $table->string('email')->nullable()->unique();
         $table->string('senha')->nullable();

        $table->timestamps();
    });
}
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
