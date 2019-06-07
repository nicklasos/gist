Remove element from array while iterating it
```go
m = []int{3, 7, 2, 9, 4, 5}

for i := len(m)-1; i >= 0; i-- {
    if m[i] < 5 {
        m = append(m[:i], m[i+1:]...)
    }
}
```
