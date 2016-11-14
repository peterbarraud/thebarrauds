#!/c/Users/barraud/AppData/Local/Programs/Python/Python35/python

import xml.etree.ElementTree as ET
import os

class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'

def setup_dataobjects(root):
    for table in root.findall('./tables/table'):
        className = table.get('name')
        classfilename = className + '.php'
    	#only create file if it exists
        if (os.path.isfile(classfilename)) :
            print ('{} file already exists. We are not overwriting'.format(classfilename))
        else :
            with open (classfilename,'w') as objectfile:
                objectfile.write("<?php\n")
                objectfile.write("require_once dirname(__FILE__) . '/common/objectbase.php';\n")
                objectfile.write("class {} extends objectbase {{}}\n".format(className))
                objectfile.write("?>\n")
        classcollectionfilename = className + 'collection.php'
        if (os.path.isfile(classcollectionfilename)) :
            print ('{} file already exists. We are not overwriting'.format(classcollectionfilename))
        else :
            with open (classcollectionfilename,'w') as objectfile:
                objectfile.write("<?php\n")
                objectfile.write("require_once dirname(__FILE__) . '/common/collectionbase.php';\n")
                objectfile.write("class {}collection extends collectionbase {{}}\n".format(className))
                objectfile.write("?>\n")

def setup_db_meta(root):
    with open ('common/dbmetadata.json','w') as dbmetafile:
        db = root.find("./db")
        dbmetafile.write('{')
        dbmetafile.write('"dbserver":"' + root.attrib['server'] + ' ",')
        dbmetafile.write('"dbuser":"' + root.attrib['user'] + '",')
        dbmetafile.write('"dbpwd":"' + root.attrib['password'] + '",')
        dbmetafile.write('"dbname":"' + root.attrib['databasename'] + '"')
        dbmetafile.write('}')

def get_largest_int(int_a, int_b):
    ints = dict(tinyint=0,smallint=1,mediumint=2,int=3,bigint=4)
    if ints[int_a] > ints[int_b]:
        return int_a
    elif ints[int_a] < ints[int_b]:
        return int_b
    else:
        return int_a




def setup_db_sql(sql_file):
    f = open (sql_file,'w')
    f.close()
    while True:
        statement = yield
        with open (sql_file,'a') as f:
            f.write(statement)
            f.write("\n")

def setup_base_tables(root,db_sql):
    for table in root.findall('./tables/table'):
        table_name = table.get('name')
        statement = 'create table if not exists {} ('.format(table_name)
        if table.get('id_type') != None:
            statement += 'id {} unsigned NOT NULL AUTO_INCREMENT,'.format(table.get('id_type'))
        for field in table.findall('./fields/field'):
            field_name = field.find('name').text
            field_type = field.find('type').text
            field_size = "({})".format(field.find('size').text) if field.find('size') != None else ''
            statement += ' {0} {1} {2},'.format(field_name,field_type,field_size,)
        statement += ' primary key(id)) ENGINE=InnoDB;'
        db_sql.send(statement)

def setup_related_tables(root,db_sql):
    for table in root.findall('./relatedtables/relation'):
        for child in table.findall('./children/table'):
            parent_id_type = root.find('./tables/table[@name="{}"]'.format(table.get('parent'))).get('id_type')
            child_id_type = root.find('./tables/table[@name="{}"]'.format(child.text)).get('id_type')
            related_id_type = get_largest_int(parent_id_type,child_id_type)
            statement = 'create table if not exists {}_map_{} ('.format(table.get('parent'),child.text)
            statement += 'id {} unsigned NOT NULL AUTO_INCREMENT,'.format(related_id_type)
            statement += '{}id {} unsigned NOT NULL,'.format(table.get('parent'),parent_id_type)
            statement += '{}id {} unsigned NOT NULL,'.format(child.text,child_id_type)
            statement += 'FOREIGN KEY (`{0}id`) REFERENCES `{0}` (`id`),'.format(table.get('parent'))
            statement += 'FOREIGN KEY (`{0}id`) REFERENCES `{0}` (`id`),'.format(child.text)
            statement += ' primary key (id)) ENGINE=InnoDB;'
            db_sql.send(statement)

def init_data(root,db_sql):
    for table in root.findall('./tabledata/table'):
        if table.get('datasetup') == 'reset':
            # truncate the table
            db_sql.send('SET FOREIGN_KEY_CHECKS=0;')
            db_sql.send('truncate {};'.format(table.get('name')))
            db_sql.send('SET FOREIGN_KEY_CHECKS=1;')
        statement = 'insert into {} ('.format(table.get('name'))
        for field in table.findall('./fields/field'):
            statement += field.text + ','
        statement = statement.rstrip(',') + ') values '
        for values in table.findall('./values'):
            value_set = '('
            for value in values.findall('./value'):
                value_set += value.text + ','
            value_set = value_set.rstrip(',') + '),'
            statement += value_set
        statement = statement.rstrip(',') + ';'
        db_sql.send(statement)



def get_xml_root():
    tree = ET.parse('db.xml')
    return tree.getroot()
def main():
    root = get_xml_root()
    db_sql = setup_db_sql('db.sql')
    next(db_sql)
    # first let's create the base tables
    setup_base_tables(root,db_sql)
    setup_related_tables(root,db_sql)
    init_data(root,db_sql)
    print('db.xml is ready now. Use the db.xml file and set up the database')
    print("after you're done, come back here and continue with the dataobjects setup")
    cont = input('ready to set up the dataobjects? Press Y to setup or n to exit. You can come back here later and set them up then. ')
    if cont.lower() == 'y':
        setup_dataobjects(root)
        setup_db_meta(root)
    else:
        print("Not setting up the dataobjects right now. Don't worry you can come back here any time and run this script to set them up.")

if __name__ == "__main__":
    main()
