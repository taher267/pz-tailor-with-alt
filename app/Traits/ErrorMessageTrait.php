<?php
namespace App\Traits;

trait ErrorMessageTrait{
    public function customerErrorMessages($email,$mobile)
   {
        return[
            'name.required' =>"<i class='fa fa-envelope'></i> সঠিক ইমেইল অ্যাড্রেস দিন!",

            'email.required' =>"ইমেইল অ্যাড্রেস দিন! <i class='fa fa-envelope'></i> ",
            'email.email' =>"<i class='fa fa-envelope'></i> সঠিক ইমেইল অ্যাড্রেস দিন!",
            'email.unique' =>"$email, ইমেইল অ্যাড্রেস পূর্ব নিবন্ধিত! <i class='fa fa-envelope'></i> ",
            
            'mobile.regex' =>'সঠিক মোবাইল নম্বর দিন!','mobile.digits' =>"মোবাইল নম্বর ১১ সংখ্যার হবে!",
            'mobile.required' =>'মোবাইল নম্বর দিন!','mobile.unique' =>"$mobile মোবাইল নম্বর পূর্ব নিবন্ধিত!",

            'photo.image' =>"<i class='fa fa-photo'></i> ছবি নির্বাচন করুন",
            'photo.mimes' =>"<i class='fa fa-photo'></i> jpg,jpeg,png ছবি নির্বাচন করুন",
       ];
   }
   public function errorMessages()
   {
        return[
            'order_number.unique' =>"$this->order_number নং অর্ডার পূর্ব নিবন্ধিত!",'order_number.max' =>$maxOrderNo." নং অর্ডার পূর্ব নিবন্ধিত!",
            "delivery_date.after"=> "অবশ্যই ডেলিভারির তারিখ আজকের ($this->todayDate) তারিখ বা তার পরের তারিখ হবে।",
            'quantity.required' => ($this->products ? Product::find($this->products)->name:'')." পশাকের পরিমাপ দিন!",'quantity.numeric' => ($this->products? Product::find($this->products)->name:'')." পরিমাণ নম্বর হবে!",
            "delivery_date.required"=>'ডেলিভারির তারিখ দিন!',"delivery_date.date"=>'সঠিকভাবে তারিখ দিন!','Full_Name.regex' =>'নাম শুধুমাত্র অক্ষর। সংখ্যা গ্রহণযোগ্য নহে','Full_Name.required' =>'নাম লিখুন!',
            'order_number.numeric' =>'অর্ডার নম্বর শুধুমাত্র সংখ্যা!','order_number.required' =>'অর্ডার নম্বর দিন!','email.email' =>"<i class='fa fa-envelope'></i> সঠিক ইমেইল অ্যাড্রেস দিন!",
            'mobile.regex' =>'সঠিক মোবাইল নম্বর দিন!','mobile.digits' =>'মোবাইল নম্বর ১১ সংখ্যার হবে!','mobile.required' =>'মোবাইল নম্বর দিন!','mobile.unique' =>'মোবাইল নম্বর পূর্ব নিবন্ধিত!','email.required' =>"<i class='fa fa-envelope'></i> ইমেইল অ্যাড্রেস দিন!",
            'email.unique' =>"<i class='fa fa-envelope'></i> ইমেইল অ্যাড্রেস পূর্ব নিবন্ধিত!",

            'delivery_system.required'=> 'সন্দেহজনক, আপনি কি করতে চাচ্ছেন???','delivery_system.min'=> 'সন্দেহজনক, আপনি কি করতে চাচ্ছেন???',
            'courier_details.required'=> 'কুরিয়ার সম্পর্কে বিস্তারিত লিখুন','delivery_charge.required'=> 'ডেলিভারি চার্জ লিখুন',
            'delivery_charge.numeric'=> 'সন্দেহজনক! ডেলিভারি চার্জ নম্বর হবে','country.required'=> 'দেশের নাম সিলেক্ট করুন',
            'city.required'=> 'শহরের নাম লিখুন','province.required'=> 'প্রদেশের নাম লিখুন','zipcode.required'=> 'জিপ কোড লিখুন','line1.required'=> 'বাড়ি নং,গ্রাম/মহল্লা সড়ক নং লিখুন',
            'products.required'=>'পণ্য নির্বাচন করুণ!','cloth_enclosure.required' => 'ঘেরের পরিমাপ দিন','hand_long.required' =>'হাতার লম্বার পরিমাপ দিন!','cloth_shoulder.required' => 'পুটের পরিমাপ দিন',
            'order_sample_images.image'=>'ছবি যুক্ত করুন','cloth_long.required' => 'লম্বার পরিমাপ দিন','order_sample_images.mimes'=>'jpg অথবা jpeg অথবা png এর ছবি যুক্ত করুন',
            'wages.required'=> "মজুরি লিখুন!",'wages.numeric'=> "মজুরি শুধুমাত্র নম্বর !",'discount.numeric'=> "ডিসকাউন্ট নম্বর হবে!",'advance.numeric'=> "অ্যাডভান্স নম্বর হবে!",'total.required'=> "মোট মজুরি দিন!",'total.numeric'=> "মোট মজুরি নম্বর হবে!",
       ];
   }
}