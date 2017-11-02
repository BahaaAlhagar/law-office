# Lawyer Office Panel | PHP Laravel Panel

- [About](#about) عن التطبيق
- [Requirements](#requirements) المتطلبات
- [Installation](#installation) التثبيت

## About

Simple Panel to control lawyer office in arabic, including Cases & Office Clients & Contracts & Todos & Files Mangement.

## <div dir="rtl">عن التطبيق</div>
<div dir="rtl">
تطبيق لادارة مكاتب المحاماة يسهل انجاز الاعمال الاداراية ومتابعة الجلسات ويتميز بالاتى :

- سهولة البحث عن اى قضية او موكل او خصم او توكيل لاستحضار بياناته.
- عرض موكلى المكتب بالاسم + عرض الخصوم.
- عرض توكيلات وقضايا واحكام كل موكل او خصم.
- صفحة خاصة لملفات كل شخص.
- عرض توكيلات المكتب حسب انواعها سواء كانت عامة او خاصة بالاضافة الى عرض عقود الوكالة بارقامها وكذلك الموكلين فى كل عقد وكالة او توكيل
- عرض قضايا المكتب حسب نوع القضية (جنائى - مدنى - ادارى .... الخ).
- عرض الاعمال الادارية مرتبة حسب تاريخها وموقفها من الانجاز.
- عرض الجلسات حسب نوع القضية.
- صفحة خاصة لكل قضية تحتوى على الجلسات وقراراتها و الخصوم بتوكيلاتهم و صفتهم.
- قسم خاص لملفات القضية كصور عريضة الدعوى او الاحكام او المحاضر الخ..
- عرض ارقام حصر الاحكام الجنائية حسب درجة التقاضى وتاريخ سقوط الحكم بالتقادم.
- عرض الجاسات السابقة التى لا تحتوى على قرارات سواء باتاجيل او احكام لمتابعتها.
- عرض القضايا التى لا تحتوى على رقم القضية الجزئى او المستانف لاستيفائه.
- عرض القضايا التى لا تحتوى على خصوم لاستيفائهم.
- عرض القضايا التى لا تحتوى على جلسات لاستيفائهم.
- عرض احكام الادانة الجنائية التى لا تحتوى على ارقام حصر لاستيفائها.
- عرض الاحكام الغيابية لاتخاذ اجراءات الاعلان.
- عرض الاحكام الحضورية + تاريخ نهاية الطعن فى الحكم لامكانية متابعة الاحكام واوقات الطعن فيها.
- عرض الاحكام الجنائية الصادرة ضد موكلى المكتب وتاريخ سقوطها.
- عرض الاحكام الجنائية الصادرة لصالح موكلى المكتب وتاريخ سقوطها.
</div>

## Requirements <span dir="rtl">المتطلبات</span>

```bash
	
    PHP >= 7.0.0
    OpenSSL PHP Extension
    PDO PHP Extension
    Mbstring PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension

```

## Installation

1. Download or Clone this Repository

2. From your this Repository root folder in terminal run:

```bash
    composer install
```
then

```bash
    php arstian migrate --seed
```

3. Navigate to the browser and use the default admin & password to log in

```bash
    username: admin@law.dev
    password: secret
```


## <div dir="rtl">التثبيت</div>

<div dir="rtl">
1. حمل او انسخ التطيبق

2. من داخل المجلد الرئيسى للتطبيق افتح terminal واخل الاوامر التالية:

```bash
    composer install
```
ثم

```bash
    php arstian migrate --seed
```

3. افتح التطبيق باستخدام المتصفح واستخدم البيانات التالية للدخول

```bash
    username: admin@law.dev
    password: secret
```
</div>
