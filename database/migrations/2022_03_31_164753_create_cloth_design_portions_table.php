<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('cloth_design_portions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->string('image')->nullable();
            $table->string('optional')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cloth_design_portions');
    }
};

// INSERT INTO `cloth_design_portions` (`id`, `name`, `type`, `image`, `optional`) VALUES
// (1, 'শেরওয়ানী রাউন্ড কলার ক্যাটালগ', 'collar', NULL, NULL),
// (2, 'শেরওয়ানী কলার', 'collar', NULL, NULL),
// (3, 'শেরওয়ানী কলার ক্যাটালগ', 'collar', NULL, NULL),
// (4, 'শেরওয়ানী রাউন্ড কলার', 'collar', NULL, NULL),
// (5, 'বেল্ড কলার', 'collar', NULL, NULL),
// (6, 'রাউন্ড বেল্ড গলা', 'collar', NULL, NULL),
// (7, 'শার্ট কলার', 'collar', NULL, NULL),
// (8, 'কলারে হালকা সেইভ হবে', 'collar', NULL, NULL),
// (9, 'কলার প্লেটে সাত সুতা', 'collar', NULL, NULL),
// (10, 'কলার প্লেট', 'collar', NULL, NULL),
// (11, 'লুজ হাতা', 'sleeve', NULL, NULL),
// (12, 'হাতার নিচ ৩ সুতা', 'sleeve', NULL, NULL),
// (13, 'সাইড ১.৫ সুতা', 'sleeve', NULL, NULL),
// (14, 'স্ট্যাট কাফ', 'cuff', NULL, NULL),
// (15, 'রাউন্ড কাফ', 'cuff', NULL, NULL),
// (16, 'ডাবল প্লেট', 'plate', NULL, NULL),
// (17, 'ডাবল প্লেট উল্টা', 'plate', NULL, NULL),
// (18, 'নরমাল প্লেট', 'plate', NULL, NULL),
// (19, 'নক সহ', 'plate', NULL, NULL),
// (20, 'চোক্কা প্লেট', 'plate', NULL, NULL),
// (21, 'ডিজাইন বুতাম', 'plate', NULL, NULL),
// (22, 'বুকে এক পকেট', 'pocket', NULL, NULL),
// (23, 'বুকে ১ ১/২ পকেট', 'pocket', NULL, NULL),
// (24, 'বুকে মেসওয়াক পকেট', 'pocket', NULL, NULL),
// (25, 'ডান পাশে ১ পকেট', 'pocket', NULL, NULL),
// (26, 'বাম পাশে ১ পকেট', 'pocket', NULL, NULL),
// (27, '২ পাশে পকেট', 'pocket', NULL, NULL),
// (28, '১টি মোবাইল পকেট', 'pocket', NULL, NULL),
// (29, 'পিছনে তিরা', 'back', NULL, NULL),
// (30, 'কলার, প্লেট ও হাতায় পাইপিং', 'piping', NULL, NULL),
// (31, 'কলার প্লাট ও হাতার পট্টি অন্য কাপর দিয়ে পাইপিং', 'piping', NULL, NULL),
// (32, 'কলার প্লেটে অন্য কাপর দিয়ে, শুধু হাতায় পাইপিং', 'piping', NULL, NULL),
// (33, 'কলারের ১ দিকে প্লাটের ৩ দিকে ও হাতার পাইপিং', 'piping', NULL, NULL),
// (34, 'বুকে চেইন', 'zip', NULL, NULL),
// (35, 'ডান পকেটে চেইন', 'zip', NULL, NULL),
// (36, 'বাম পকেটে চেইন', 'zip', NULL, NULL),
// (37, 'মোবাইল পকেটে চেইন', 'zip', NULL, NULL),
// (38, 'হাতা নিচ ৩ সুতা', 'Sewing', NULL, NULL),
// (39, 'TR', 'embroidery', NULL, NULL),
// (40, 'BD', 'embroidery', NULL, NULL),
// (41, 'No.', 'embroidery', NULL, NULL),
// (42, 'কারচুপির নাম', 'karchupi', NULL, NULL);
