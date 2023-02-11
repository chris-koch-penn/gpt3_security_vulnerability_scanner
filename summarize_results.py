#! python3
import os
from pathlib import Path
from collections import Counter
from glob import glob
from typing import Tuple


def process_file(path: Path, response_prefixes: Counter[str]):
    responses = []
    with open(path, "r") as f:
        lines = f.readlines()
        current_response = ""
        for line in lines:
            if "##" in line:
                if current_response:
                    responses.append(current_response)
                current_response = ""
            elif not current_response and "vulnerab" not in line.lower():
                continue
            else:
                current_response += line
        responses.append(current_response)

        for response in responses:
            prefix = response.split("\n")[0]
            prefix = prefix.split(":")[0]
            if not prefix and not response.strip():
                print(response)
            response_prefixes[prefix.lower()] += 1


def count_number_of_bugs(path: Path, bug_counts: Counter[str]):
    with open(path, "r") as f:
        lines = f.readlines()
        number_prefixes = [f"{i}. " for i in range(15)]
        number_prefixes.append("-")
        for line in lines:
            for prefix in number_prefixes:
                if line.startswith(prefix):
                    short_path = "/".join(path.parts[-2:])
                    bug_counts[short_path] += 1


def summarize_file_types() -> Tuple[int, str]:
    files = glob("./**/*", recursive=True)
    files = [Path(f).resolve() for f in files]
    suffixes = [f.suffix for f in files if ".git" not in str(
        f) and f.is_file()]
    files = Counter(suffixes)
    del files[".md"]
    del files[""]
    num_code_files = sum(files.values())
    file_frequency = str(files).removeprefix("Counter(")[:-1]
    return num_code_files, file_frequency


if __name__ == "__main__":
    code_dir = "/Users/chriskoch/projects/vulnerable_code_gpt3_analyzer"
    files = os.listdir(code_dir)
    files = [(code_dir / Path(f)).resolve().rglob("README.md") for f in files]
    files = [f2 for f1 in files for f2 in f1]
    response_prefixes = Counter()
    bug_counts = Counter()
    for path in files:
        count_number_of_bugs(path, bug_counts)
        process_file(path, response_prefixes)
    total_bugs = sum(bug_counts.values())
    num_files_scanned = sum(response_prefixes.values())
    num_code_files, file_frequency = summarize_file_types()
    vulnerable_files = num_code_files - \
        response_prefixes["no vulnerabilities detected."]
    response_prefixes["no response given"] += num_code_files - \
        num_files_scanned
    response_prefixes = str(response_prefixes).removeprefix("Counter(")[:-1]
    print(
        f"Vulnerabilities detected in {vulnerable_files} / {num_code_files} files.")
    print(f"Detected {total_bugs} vulnerabilities in total.\n")
    print(f"Frequency of cleaned GPT prompt response types (one response per file scanned):")
    print(response_prefixes, "\n")
    print("Distribution of file types in this repo: ")
    print(f"{num_code_files} files of code in total (excluding markdown and flatfiles)")
    print(file_frequency)
