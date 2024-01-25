export interface DBForeignKey {
    table: string,
    field: string
}

export interface DBFieldType {
    primary: boolean;
    sql_type: string;
    pdo_type: number;
    not_null: boolean;
    extra_params: string;
    allow_insert: boolean;
    foreign_key: DBForeignKey | null;
}

export interface DBTableType {
    title: string;
    fields: {
        [fieldName: string]: DBFieldType;
    };
    actions: any;
    display_name?: string;
}
