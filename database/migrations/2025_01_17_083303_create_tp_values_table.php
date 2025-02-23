<?php

use Illuminate\Database\Migrations\Migration;  
use Illuminate\Database\Schema\Blueprint;  
use Illuminate\Support\Facades\Schema;  
  
class CreateTpValuesTable extends Migration  
{  
    public function up()  
    {  
        Schema::create('tp_values', function (Blueprint $table) {  
            $table->id();  
            $table->foreignId('student_id')->constrained()->onDelete('cascade');  
            $table->integer('tp_index');  
            $table->decimal('value', 5, 2); // Adjust precision and scale as needed  
            $table->timestamps();  
        });  
    }  
  
    public function down()  
    {  
        Schema::dropIfExists('tp_values');  
    }  
}  
