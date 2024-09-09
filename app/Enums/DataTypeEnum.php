<?php
namespace App\Enums;

enum DataTypeEnum:string {
    const String = 'string';
    const Integer = 'integer';
    const Float = 'float';
    const Date = 'date';
    const Boolean = 'boolean';
    const ALL=[
        self::String,
        self::Integer,
        self::Float,
        self::Date,
        self::Boolean,
    ];
}
