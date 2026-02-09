import 'package:flutter/material.dart';
import '../models/expense.dart';
import '../services/expense_service.dart';

class ExpenseScreen extends StatefulWidget {
  const ExpenseScreen({super.key});

  @override
  State<ExpenseScreen> createState() => _ExpenseScreenState();
}

class _ExpenseScreenState extends State<ExpenseScreen> {
  // ===== Form controllers =====
  final TextEditingController titleController = TextEditingController();
  final TextEditingController amountController = TextEditingController();
  final TextEditingController dateController = TextEditingController();

  String selectedCategory = 'Grocery';
  String selectedPayment = 'Cash';

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[300],
      body: Row(
        children: [
          // ===== Sidebar =====
          Container(
            width: 220,
            color: Colors.grey[200],
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                sidebarTitle("Dashboard"),
                sidebarSection("Income", ["Add Income", "View Income"]),
                sidebarSection("Expenses", ["Add Expense", "View Expense"]),
                sidebarSection("Budget", ["Add Budget", "View Budget"]),
                sidebarSection("Report", ["View Report"]),
              ],
            ),
          ),

          // ===== Main Content =====
          Expanded(
            child: Center(
              child: Container(
                width: 420,
                padding: const EdgeInsets.all(24),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const Text(
                      "Add Expense",
                      style: TextStyle(
                        fontSize: 22,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 20),

                    inputField("Expense Title", controller: titleController),
                    dropdownField(
                      "Category",
                      ["Grocery", "Shopping", "Education", "Transport"],
                      value: selectedCategory,
                      onChanged: (val) {
                        setState(() => selectedCategory = val!);
                      },
                    ),
                    inputField(
                      "Amount",
                      controller: amountController,
                      keyboardType: TextInputType.number,
                    ),
                    dropdownField(
                      "Payment Method",
                      ["Cash", "Card", "Online"],
                      value: selectedPayment,
                      onChanged: (val) {
                        setState(() => selectedPayment = val!);
                      },
                    ),
                    inputField(
                      "Date",
                      controller: dateController,
                      hint: "YYYY-MM-DD",
                    ),

                    const SizedBox(height: 20),

                    SizedBox(
                      width: 120,
                      height: 40,
                      child: ElevatedButton(
                        onPressed: submitExpense,
                        child: const Text("Submit"),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ===== Sidebar Helpers =====
  Widget sidebarTitle(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
    );
  }

  Widget sidebarSection(String title, List<String> items) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 12),
        Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
        ...items.map(
          (e) => Padding(
            padding: const EdgeInsets.only(left: 12, top: 6),
            child: Text(e),
          ),
        ),
      ],
    );
  }

  // ===== Form Helpers =====
  Widget inputField(
    String label, {
    TextEditingController? controller,
    TextInputType keyboardType = TextInputType.text,
    String? hint,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          SizedBox(width: 140, child: Text(label)),
          Expanded(
            child: TextField(
              controller: controller,
              keyboardType: keyboardType,
              decoration: InputDecoration(
                hintText: hint,
                isDense: true,
                border: const OutlineInputBorder(),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget dropdownField(
    String label,
    List<String> items, {
    String? value,
    void Function(String?)? onChanged,
  }) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          SizedBox(width: 140, child: Text(label)),
          Expanded(
            child: DropdownButtonFormField<String>(
              value: value,
              decoration: const InputDecoration(
                isDense: true,
                border: OutlineInputBorder(),
              ),
              items: items
                  .map((e) => DropdownMenuItem(value: e, child: Text(e)))
                  .toList(),
              onChanged: onChanged,
            ),
          ),
        ],
      ),
    );
  }

  // ===== Submit function =====
  void submitExpense() async {
    final expense = Expense(
      title: titleController.text,
      category: selectedCategory,
      amount: double.tryParse(amountController.text) ?? 0,
      paymentMethod: selectedPayment,
      date: dateController.text,
    );

    bool success = await ExpenseService.addExpense(expense);

    if (success) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Expense added successfully')),
      );

      // Clear form
      titleController.clear();
      amountController.clear();
      dateController.clear();
      setState(() {
        selectedCategory = 'Grocery';
        selectedPayment = 'Cash';
      });
    } else {
      ScaffoldMessenger.of(
        context,
      ).showSnackBar(const SnackBar(content: Text('Failed to add expense')));
    }
  }
}
