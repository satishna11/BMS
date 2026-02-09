import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/expense.dart';

class ExpenseService {
  static const String baseUrl = 'http://192.168.1.5/api/expenses';

  static Future<List<Expense>> fetchExpenses() async {
    final response = await http.get(Uri.parse(baseUrl));
    final body = jsonDecode(response.body);

    return (body['data'] as List).map((e) => Expense.fromJson(e)).toList();
  }

  static Future<bool> addExpense(Expense expense) async {
    final response = await http.post(
      Uri.parse(baseUrl),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode(expense.toJson()),
    );

    if (response.statusCode == 201) {
      return true;
    } else {
      print(response.body);
      return false;
    }
  }
}
